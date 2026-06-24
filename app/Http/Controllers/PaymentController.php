<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Order;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class PaymentController extends Controller
{
    public function __construct()
    {
        // Set konfigurasi Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$clientKey = env('MIDTRANS_CLIENT_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized = true;
        Config::$is3ds = false;
    }

    /**
     * Buat transaksi pembayaran QRIS
     */
    public function createQRIS(Request $request, int $orderId)
    {
        try {
            $order = Order::with('orderItems.menuItem')->findOrFail($orderId);
            
            Log::info('QRIS page accessed', ['order_id' => $orderId, 'order_status' => $order->order_status]);

            // Validasi order
            if ($order->order_status !== 'pending') {
                Log::warning('Order not pending', ['order_id' => $orderId, 'status' => $order->order_status]);
                return back()->with('error', 'Order ini sudah diproses atau dibayar.');
            }

            $snapToken = $order->payment_token;

            // Jika belum ada payment token, buat baru
            if (!$snapToken) {
                // Detail transaksi
                $transactionDetails = [
                    'order_id' => $order->id,
                    'gross_amount' => $order->total_price,
                ];

                // Item details
                $itemDetails = [];
                foreach ($order->orderItems as $item) {
                    if (!$item->menuItem) {
                        Log::warning('Menu item not found', ['order_item_id' => $item->id]);
                        continue;
                    }
                    $itemDetails[] = [
                        'id' => $item->menu_item_id,
                        'price' => $item->price,
                        'quantity' => $item->qty,
                        'name' => $item->menuItem->name,
                    ];
                }

                // Customer details
                $customerDetails = [
                    'first_name' => $order->customer_name ?? 'Customer',
                    'email' => $order->customer_email ?? 'customer@example.com',
                    'phone' => $order->customer_phone ?? '-',
                ];

                // Parameter untuk pembayaran
                $params = [
                    'transaction_details' => $transactionDetails,
                    'item_details' => $itemDetails,
                    'customer_details' => $customerDetails,
                    'expiry' => [
                        'unit' => 'minutes',
                        'duration' => 30, // Pembayaran expired dalam 30 menit
                    ],
                ];

                $snapToken = Snap::getSnapToken($params);
                
                // Simpan snap token dan midtrans order id ke order
                $order->payment_token = $snapToken;
                $order->midtrans_order_id = $order->id; // Store the same order_id for Midtrans
                $order->save();

                Log::info('QRIS created', ['order_id' => $order->id, 'midtrans_order_id' => $order->midtrans_order_id]);
            } else {
                Log::info('Using existing payment token', ['order_id' => $order->id]);
            }

            return view('payment.qris', compact('order', 'snapToken'));
        } catch (\Exception $e) {
            Log::error('Failed to create QRIS', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return back()->with('error', 'Gagal membuat pembayaran: ' . $e->getMessage());
        }
    }

    /**
     * Show receipt after successful payment
     */
    public function showReceipt($orderId)
    {
        try {
            $order = Order::with('orderItems.menuItem')->findOrFail($orderId);
            
            Log::info('Receipt page accessed', [
                'order_id' => $order->id,
                'order_status' => $order->order_status,
                'payment_status' => $order->payment_status
            ]);
            
            // Update order status if payment was successful but not yet updated in database
            // This handles cases where webhook hasn't been called yet
            if ($order->payment_status !== 'paid' && $order->order_status !== 'paid') {
                // Try to check status from Midtrans
                try {
                    $status = \Midtrans\Transaction::status($order->id);
                    if (isset($status->transaction_status) && ($status->transaction_status === 'settlement' || $status->transaction_status === 'capture')) {
                        $order->order_status = 'paid';
                        $order->payment_status = 'paid'; // Use 'paid' instead of 'success' to match enum
                        $order->midtrans_transaction_id = $status->transaction_id ?? null;
                        $order->save();
                        
                        Log::info('Order status updated from Midtrans API', [
                            'order_id' => $order->id,
                            'transaction_status' => $status->transaction_status
                        ]);
                    }
                } catch (\Exception $e) {
                    Log::error('Failed to check Midtrans status: ' . $e->getMessage());
                }
                
                // Still not paid after checking Midtrans
                if ($order->payment_status !== 'paid' && $order->order_status !== 'paid') {
                    return redirect()->route('payment.qris', $orderId)->with('error', 'Pembayaran belum berhasil. Silakan tunggu beberapa detik atau coba lagi.');
                }
            }

            return view('payment.receipt', compact('order'));
        } catch (\Exception $e) {
            Log::error('Receipt page error: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'Terjadi kesalahan saat menampilkan struk');
        }
    }

    /**
     * Handle webhook notification dari Midtrans
     */
    public function handleNotification(Request $request)
    {
        try {
            $notification = new Notification();

            /** @var string|null $orderId */
            $orderId = $notification->order_id;
            /** @var string|null $transactionStatus */
            $transactionStatus = $notification->transaction_status;
            /** @var string|null $fraudStatus */
            $fraudStatus = $notification->fraud_status;

            Log::info('Midtrans webhook received', [
                'order_id' => $orderId,
                'transaction_status' => $transactionStatus,
                'fraud_status' => $fraudStatus
            ]);

            if (!$orderId) {
                Log::error('Midtrans webhook: order_id is null');
                return response('Error', 500);
            }

            // Try to find order by midtrans_order_id first, then by id
            $order = Order::where('midtrans_order_id', $orderId)->first();
            
            if (!$order) {
                // Try to find by regular id
                $order = Order::find($orderId);
            }

            if (!$order) {
                Log::error('Midtrans webhook: Order not found', ['order_id' => $orderId]);
                return response('Error', 404);
            }

            Log::info('Order found', ['order_id' => $order->id, 'midtrans_order_id' => $order->midtrans_order_id]);

            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'accept') {
                    $order->order_status = 'paid';
                    $order->payment_status = 'paid'; // Use 'paid' instead of 'success' to match enum
                }
            } else if ($transactionStatus == 'settlement') {
                $order->order_status = 'paid';
                $order->payment_status = 'paid'; // Use 'paid' instead of 'success' to match enum
            } else if ($transactionStatus == 'cancel') {
                if ($fraudStatus == 'challenge') {
                    $order->order_status = 'cancelled';
                    $order->payment_status = 'failed';
                } else {
                    $order->order_status = 'cancelled';
                    $order->payment_status = 'failed';
                }
            } else if ($transactionStatus == 'deny') {
                $order->order_status = 'cancelled';
                $order->payment_status = 'failed';
            } else if ($transactionStatus == 'expire') {
                $order->order_status = 'cancelled';
                $order->payment_status = 'expired';
            } else if ($transactionStatus == 'pending') {
                $order->order_status = 'pending';
                $order->payment_status = 'unpaid'; // Use 'unpaid' instead of 'pending' to match enum
            }

            $order->save();

            Log::info('Order status updated', [
                'order_id' => $order->id,
                'order_status' => $order->order_status,
                'payment_status' => $order->payment_status
            ]);

            return response('OK', 200);
        } catch (\Exception $e) {
            Log::error('Midtrans webhook error: ' . $e->getMessage());
            return response('Error', 500);
        }
    }

    /**
     * Cek status pembayaran
     */
    public function checkStatus(int $orderId)
    {
        $order = Order::findOrFail($orderId);

        // Cek status dari Midtrans API
        try {
            /** @var mixed $status */
            $status = \Midtrans\Transaction::status($order->id);
            /** @var string|null $transactionStatus */
            $transactionStatus = $status->transaction_status;
            /** @var string|null $fraudStatus */
            $fraudStatus = $status->fraud_status;

            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'accept') {
                    $order->order_status = 'paid';
                    $order->payment_status = 'paid'; // Use 'paid' instead of 'success' to match enum
                }
            } else if ($transactionStatus == 'settlement') {
                $order->order_status = 'paid';
                $order->payment_status = 'paid'; // Use 'paid' instead of 'success' to match enum
            } else if ($transactionStatus == 'cancel') {
                if ($fraudStatus == 'challenge') {
                    $order->order_status = 'cancelled';
                    $order->payment_status = 'failed';
                } else {
                    $order->order_status = 'cancelled';
                    $order->payment_status = 'failed';
                }
            } else if ($transactionStatus == 'deny') {
                $order->order_status = 'cancelled';
                $order->payment_status = 'failed';
            } else if ($transactionStatus == 'expire') {
                $order->order_status = 'cancelled';
                $order->payment_status = 'expired';
            } else if ($transactionStatus == 'pending') {
                $order->order_status = 'pending';
                $order->payment_status = 'unpaid'; // Use 'unpaid' instead of 'pending' to match enum
            }

            $order->save();
        } catch (\Exception $e) {
            // Ignore error, just return current status
        }

        return response()->json([
            'order_id' => $order->id,
            'order_status' => $order->order_status,
            'payment_status' => $order->payment_status,
            'total_price' => $order->total_price,
        ]);
    }
}
