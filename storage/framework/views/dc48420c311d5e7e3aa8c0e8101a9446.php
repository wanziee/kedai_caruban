<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan - Kedai Caruban</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        
        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
        }
        
        header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #1B4434;
            padding-bottom: 20px;
        }
        
        h1 {
            font-size: 24px;
            color: #1B4434;
            margin-bottom: 5px;
        }
        
        .header-info {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
            padding-top: 15px;
        }
        
        .header-info p {
            font-size: 12px;
        }
        
        .summary {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .summary-card {
            border: 2px solid #1B4434;
            padding: 15px;
            border-radius: 5px;
            text-align: center;
        }
        
        .summary-card h3 {
            font-size: 12px;
            color: #666;
            margin-bottom: 8px;
            text-transform: uppercase;
        }
        
        .summary-card .amount {
            font-size: 18px;
            font-weight: bold;
            color: #1B4434;
        }
        
        h2 {
            font-size: 16px;
            color: #1B4434;
            margin: 25px 0 15px 0;
            border-bottom: 2px solid #1B4434;
            padding-bottom: 8px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        th {
            background-color: #1B4434;
            color: white;
            padding: 10px;
            text-align: left;
            font-size: 12px;
            font-weight: bold;
        }
        
        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            font-size: 12px;
        }
        
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        .text-right {
            text-align: right;
        }
        
        .rank {
            font-weight: bold;
            color: white;
            background-color: #1B4434;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
        }
        
        .category-item {
            display: flex;
            justify-content: space-between;
            padding: 10px;
            border: 1px solid #ddd;
            margin-bottom: 8px;
            border-radius: 3px;
            background-color: #f9f9f9;
        }
        
        .two-column {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .column-title {
            font-size: 12px;
            color: #666;
            margin-bottom: 8px;
            text-transform: uppercase;
            font-weight: bold;
        }
        
        footer {
            margin-top: 40px;
            text-align: right;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            font-size: 11px;
            color: #666;
        }
        
        .no-data {
            text-align: center;
            padding: 20px;
            color: #999;
            font-style: italic;
        }
        
        @media print {
            body {
                margin: 0;
                padding: 0;
            }
            .container {
                padding: 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>LAPORAN PENJUALAN</h1>
            <p>Kedai Caruban</p>
            <div class="header-info">
                <p><strong>Periode:</strong> <?php echo e($months[$month]); ?> <?php echo e($year); ?></p>
                <p><strong>Tanggal Cetak:</strong> <?php echo e(now()->format('d/m/Y H:i')); ?></p>
            </div>
        </header>

        <!-- Summary -->
        <div class="summary">
            <div class="summary-card">
                <h3>Total Penjualan</h3>
                <div class="amount">Rp <?php echo e(number_format($totalSales, 0, ',', '.')); ?></div>
            </div>
            <div class="summary-card">
                <h3>Total Pesanan Selesai</h3>
                <div class="amount"><?php echo e($totalOrders); ?></div>
            </div>
        </div>

        <!-- Top Items & Categories -->
        <div class="two-column">
            <div>
                <p class="column-title">10 Menu Terlaris</p>
                <?php if($topItems->count()): ?>
                    <?php $__currentLoopData = $topItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="category-item">
                            <div style="display: flex; gap: 10px; align-items: center;">
                                <span class="rank"><?php echo e($idx + 1); ?></span>
                                <div>
                                    <div style="font-weight: bold;"><?php echo e($item->name); ?></div>
                                    <div style="font-size: 10px; color: #666;"><?php echo e($item->total_quantity); ?> terjual</div>
                                </div>
                            </div>
                            <div style="font-weight: bold;">Rp <?php echo e(number_format($item->total_price, 0, ',', '.')); ?></div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <div class="no-data">Tidak ada data</div>
                <?php endif; ?>
            </div>

            <div>
                <p class="column-title">Penjualan Berdasarkan Kategori</p>
                <?php if($salesByCategory->count()): ?>
                    <?php $__currentLoopData = $salesByCategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="category-item">
                            <div>
                                <div style="font-weight: bold;"><?php echo e($category->name); ?></div>
                                <div style="font-size: 10px; color: #666;"><?php echo e($category->quantity); ?> item</div>
                            </div>
                            <div style="font-weight: bold;">Rp <?php echo e(number_format($category->total, 0, ',', '.')); ?></div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <div class="no-data">Tidak ada data</div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Orders Details -->
        <h2>Detail Pesanan</h2>
        <?php if($orders->count()): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID Pesanan</th>
                        <th>Tanggal</th>
                        <th>Total Item</th>
                        <th class="text-right">Total Harga</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>#<?php echo e($order->id); ?></td>
                            <td><?php echo e($order->created_at->format('d/m/Y H:i')); ?></td>
                            <td><?php echo e($order->orderItems->count()); ?> item</td>
                            <td class="text-right">Rp <?php echo e(number_format($order->total_price, 0, ',', '.')); ?></td>
                            <td><?php echo e(ucfirst($order->order_status)); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="no-data">Tidak ada pesanan untuk periode ini</div>
        <?php endif; ?>

        <footer>
            <p>Laporan ini dihasilkan secara otomatis oleh sistem Kedai Caruban</p>
        </footer>
    </div>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
<?php /**PATH /Applications/MAMP/htdocs/kedai-caruban/resources/views/admin/reports/sales-print.blade.php ENDPATH**/ ?>