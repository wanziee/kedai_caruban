# Panduan Sistem Role-Based Kedai Caruban

## 📋 Ringkasan Perubahan

Sistem telah diperbarui dengan struktur role yang jelas:
- ❌ **Owner** - Dihapus
- ✅ **Admin** - Mengelola kategori, menu, pesanan, dan laporan
- ✅ **Cashier** - Mengelola pesanan dan melihat dashboard harian

---

## 🔐 Akses Berdasarkan Role

### Admin Dashboard (`/admin`)
Hanya user dengan role **admin** yang bisa akses:
- 📊 **Beranda** - Lihat statistik (Total pesanan, selesai, pending)
- 📁 **Kategori** - CRUD kategori menu
- 🍽️ **Menu** - CRUD item menu
- 📦 **Pesanan** - Lihat dan update status pesanan
- 📈 **Laporan Penjualan** - Laporan bulanan dengan print

### Cashier Dashboard (`/cashier`)
Hanya user dengan role **cashier** yang bisa akses:
- 📊 **Beranda** - Lihat statistik hari ini
- 📦 **Pesanan** - Lihat dan update status pesanan

---

## 📊 Fitur Laporan Penjualan (Admin Only)

### Akses
- Menu: Admin Panel → Laporan Penjualan
- URL: `/admin/reports/sales`

### Fitur:
1. **Filter Bulan & Tahun** - Pilih periode laporan
2. **Summary Cards**
   - Total Penjualan (Rp)
   - Total Pesanan Selesai

3. **Analytics**
   - Top 10 Menu Terlaris
   - Penjualan Berdasarkan Kategori

4. **Detail Pesanan** - Tabel lengkap pesanan selesai

5. **Cetak Laporan** 
   - Button "🖨️ Cetak"
   - Buka dalam tab baru untuk print
   - Format siap untuk printer

---

## 🔑 Default Credentials

```
Admin:
  Email: admin@kedaicabruban.com
  Password: password123

Cashier 1:
  Email: cashier@kedaicabruban.com
  Password: password123

Cashier 2:
  Email: cashier2@kedaicabruban.com
  Password: password123
```

---

## 🚀 Instalasi & Setup

### 1. Jalankan Migration
```bash
php artisan migrate:refresh --seed
```

### 2. Akses Aplikasi
- Frontend: `http://localhost/kedai-caruban/`
- Login: `http://localhost/kedai-caruban/admin/login`

### 3. Login dengan Role
- **Admin** untuk manage kategori/menu/laporan
- **Cashier** untuk manage pesanan hari-hari

---

## 📁 File-File Baru

### Middleware
- `app/Http/Middleware/IsAdmin.php` - Check admin role
- `app/Http/Middleware/IsCashier.php` - Check cashier role
- `app/Http/Middleware/IsAdminOrCashier.php` - Check either role

### Controllers
- `app/Http/Controllers/CashierController.php` - Cashier logic
- `app/Http/Controllers/ReportController.php` - Sales report logic

### Views
```
resources/views/
├── cashier/
│   ├── layout.blade.php
│   ├── dashboard.blade.php
│   └── orders/
│       ├── index.blade.php
│       └── show.blade.php
└── admin/
    └── reports/
        ├── sales.blade.php
        └── sales-print.blade.php
```

### Routes
- Admin: `/admin/*` dengan middleware `IsAdmin`
- Cashier: `/cashier/*` dengan middleware `IsCashier`
- Auth: Login redirect berdasarkan role

---

## ✨ Fitur Tambahan

### Dashboard Cashier
Menampilkan:
- Pesanan hari ini
- Pesanan pending
- Pesanan selesai hari ini
- Total penjualan hari ini

### Laporan Penjualan
Menampilkan:
- Filter per bulan & tahun
- Total penjualan & pesanan
- Top 10 menu terlaris dengan qty & total
- Penjualan per kategori
- Detail pesanan per bulan

### Print Report
- Otomatis buka dialog print
- Format profesional (A4)
- Include summary & detail pesanan
- Siap untuk arsip

---

## 🔄 Auth Flow

```
Login (email + password)
    ↓
Validasi credentials
    ↓
Role check:
├─ Admin → /admin/dashboard
├─ Cashier → /cashier/dashboard
└─ Other → /home
```

---

## 💡 Tips Penggunaan

1. **Admin bisa lihat semua laporan** dari menu Laporan Penjualan
2. **Cashier fokus kelola pesanan** dari dashboard
3. **Print laporan** tersedia untuk dokumen bulanan
4. **Status pesanan** bisa diupdate dari mana saja (admin/cashier)

---

## 🐛 Troubleshooting

**Masalah: Login redirect ke home?**
- Pastikan email & password benar
- Check user role di database (admin/cashier)

**Masalah: Laporan tidak muncul?**
- Pastikan sudah ada pesanan dengan status "done"
- Periksa tanggal pesanan sesuai filter

**Masalah: Middleware error?**
- Clear cache: `php artisan cache:clear`
- Clear config: `php artisan config:clear`

---

## 📞 Support
Hubungi admin jika ada pertanyaan tentang sistem ini.
