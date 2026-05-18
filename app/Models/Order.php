<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'table_number',
        'order_code',
        'customer_name',
        'total_price',
        'order_status',
        'payment_status',
        'midtrans_order_id',
        'midtrans_transaction_id',
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
