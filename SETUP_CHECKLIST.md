# CHECKLIST - Sistem Role Kedai Caruban

## ✅ Middleware
- [x] IsAdmin.php - created
- [x] IsCashier.php - created  
- [x] IsAdminOrCashier.php - created

## ✅ Routes
- [x] Admin routes dengan IsAdmin middleware
- [x] Cashier routes dengan IsCashier middleware
- [x] Auth redirect berdasarkan role
- [x] Report routes untuk admin

## ✅ Controllers
- [x] CashierController.php
- [x] ReportController.php
- [x] AuthController.php (updated)
- [x] AdminController.php (existing)

## ✅ Views - Admin
- [x] admin/layout.blade.php (updated dengan menu Laporan)
- [x] admin/dashboard.blade.php (existing)
- [x] admin/categories/* (existing)
- [x] admin/menu/* (existing)
- [x] admin/orders/* (existing)
- [x] admin/reports/sales.blade.php (baru)
- [x] admin/reports/sales-print.blade.php (baru)

## ✅ Views - Cashier
- [x] cashier/layout.blade.php (baru)
- [x] cashier/dashboard.blade.php (baru)
- [x] cashier/orders/index.blade.php (baru)
- [x] cashier/orders/show.blade.php (baru)

## ✅ Database
- [x] Migration untuk remove owner role
- [x] UserSeeder updated (hanya admin + cashier)

## ✅ Models
- [x] User.php (sudah punya role field)

## ✅ Documentation
- [x] PANDUAN_ROLE_SYSTEM.md (created)

---

## 🚀 NEXT STEPS

### 1. Jalankan Migration & Seed
```bash
php artisan migrate:refresh --seed
```

### 2. Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
```

### 3. Test Login
**Admin:**
- Email: admin@kedaicabruban.com
- Password: password123
- Expected: Redirect ke /admin/dashboard

**Cashier:**
- Email: cashier@kedaicabruban.com
- Password: password123
- Expected: Redirect ke /cashier/dashboard

### 4. Test Features

**Admin:**
- [ ] Login as admin
- [ ] Akses /admin/dashboard
- [ ] Akses Kategori
- [ ] Akses Menu
- [ ] Akses Pesanan
- [ ] Akses Laporan Penjualan
- [ ] Cetak Laporan

**Cashier:**
- [ ] Login as cashier
- [ ] Akses /cashier/dashboard
- [ ] Akses Pesanan
- [ ] Update status pesanan
- [ ] Tidak bisa akses /admin/* (should redirect to home)

---

## 📝 PERUBAHAN UTAMA

1. **Role System**
   - Owner ❌ → Admin ✅ + Cashier ✅

2. **Admin Features**
   - Existing: Dashboard, Categories, Menu, Orders
   - NEW: Laporan Penjualan (monthly, printable)

3. **Cashier Features**
   - NEW: Dashboard (daily stats)
   - NEW: Orders management

4. **Auth**
   - Updated redirect berdasarkan role

---

## 🎯 FITUR KHUSUS LAPORAN

✨ Monthly Sales Report dengan:
- Filter bulan & tahun
- Total penjualan & jumlah pesanan
- Top 10 menu terlaris
- Penjualan per kategori
- Detail pesanan per bulan
- Print-friendly format

Print otomatis membuka dialog dengan Ctrl+P untuk langsung cetak ke PDF.

---

Semua setup sudah complete! Silakan run migration & test sistem.
