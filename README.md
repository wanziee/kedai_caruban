# Kedai Caruban - Food Ordering System

A web-based food ordering system for Kedai Caruban restaurant. Customers can scan QR codes at their tables to view the menu, add items to cart, and place orders. The system includes an admin panel for managing menu items, categories, and orders.

## Features

### Frontend (Customer)
- **Home Page**: Banner display, menu categories (All, Makanan, Minuman, Snack), and menu items grid
- **Company Page**: Information about Kedai Caruban
- **Order Page**: Shopping cart with quantity management, notes, and order submission
- **QR Code Support**: Each table can have a unique QR code for direct access

### Admin Panel
- **Dashboard**: Overview of orders, statistics, and recent activity
- **Categories Management**: Create and delete menu categories
- **Menu Management**: Full CRUD for menu items (create, read, update, delete)
- **Orders Management**: View all orders, update order status (pending, paid, cooking, done, cancelled)
- **Order Details**: View individual order details with items and totals

## Tech Stack

- **Framework**: Laravel 11 (PHP 8.3)
- **Frontend**: Blade Templates with Tailwind CSS
- **Database**: MySQL with phpMyAdmin
- **JavaScript**: Alpine.js for interactivity
- **Styling**: Tailwind CSS

## Database Schema

### Menu Categories
- id
- name

### Menu Items
- id
- category_id (foreign key)
- name
- description
- price
- image
- is_available

### Orders
- id
- table_number
- order_code (unique)
- customer_name (optional)
- total_price
- order_status (pending, paid, cooking, done, cancelled)
- payment_status (unpaid, paid, expired, failed)
- midtrans_order_id (for future payment integration)
- midtrans_transaction_id (for future payment integration)
- created_at

### Order Items
- id
- order_id (foreign key)
- menu_item_id (foreign key)
- qty
- price
- notes
- subtotal

## Installation

### Prerequisites
- PHP 8.3 or higher
- Composer
- Node.js and NPM
- MySQL
- phpMyAdmin

### Setup Instructions

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd kedai-caruban-2
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure database**
   Edit `.env` file and set your database credentials:
   ```
   DB_DATABASE=kedai_caruban
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

5. **Run migrations and seeders**
   ```bash
   php artisan migrate:fresh --seed
   ```

6. **Create storage link**
   ```bash
   php artisan storage:link
   ```

7. **Build assets**
   ```bash
   npm run build
   ```

8. **Start development server**
   ```bash
   php artisan serve
   ```

9. **Access the application**
   - Frontend: http://localhost:8000
   - Admin Panel: http://localhost:8000/admin

## Usage

### For Customers
1. Scan QR code at your table
2. Browse menu items by category
3. Add items to cart
4. Add notes if needed
5. Enter table number and customer name
6. Submit order

### For Admin
1. Access admin panel at `/admin`
2. Manage categories in Categories section
3. Add/edit/delete menu items in Menu section
4. View and manage orders in Orders section
5. Update order status as needed

## Future Enhancements

- Payment gateway integration (QRIS via Midtrans)
- Real-time order notifications
- Customer authentication
- Order history
- Receipt generation
- Table-specific QR code generation

## License

This project is open-sourced software licensed under the MIT license.
