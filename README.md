# Database Setup Instructions

## Prerequisites
- PHP 7.4+ with PDO MySQL extension
- MySQL 5.7+ or MariaDB 10.3+
- Web server (Apache/Nginx) or PHP built-in server

## Step 1: Create Database
Open your MySQL client (phpMyAdmin, MySQL Workbench, or command line) and create the database:

```sql
CREATE DATABASE catalogue_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

## Step 2: Import Schema
Import the schema from `database/schema.sql`:

### Using Command Line:
```bash
mysql -u root -p catalogue_db < database/schema.sql
```

### Using phpMyAdmin:
1. Select `catalogue_db` database
2. Go to "Import" tab
3. Choose `database/schema.sql` file
4. Click "Go"

## Step 3: Configure Database Connection
Update the database credentials in `config/config.php`:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'catalogue_db');
define('DB_USER', 'root');         // Change to your MySQL username
define('DB_PASS', '');             // Change to your MySQL password
```

## Step 4: Verify Installation
1. Start the PHP server:
   ```powershell
   cd "C:\Users\Rafi Rajendranata P\Downloads\CatalogueWebsite"
   php -S localhost:8000
   ```

2. Open http://localhost:8000/catalogue
   - You should see 6 sample products loaded from the database

3. Test contact form:
   - Go to http://localhost:8000/contact
   - Fill out and submit the form
   - Check if the submission appears in the `contacts` table

## Troubleshooting

### Connection Error
If you see "Database connection failed", check:
- MySQL service is running
- Database credentials in config.php are correct
- PHP PDO MySQL extension is enabled

### No Products Showing
- Verify data was imported: `SELECT * FROM products;`
- Check database connection in `Database.php`

### Contact Form Not Saving
- Check `contacts` table exists
- Verify PHP has write permissions
- Check error logs for PDO exceptions

## Database Schema

The database includes 4 tables:

1. **categories** - Product categories with hierarchical support
2. **products** - Product details with price, descriptions, SKU
3. **product_images** - Multiple images per product with primary flag
4. **contacts** - Contact form submissions with tracking

## Sample Data

The schema includes:
- 4 categories (Electronics, Fashion, Home, Accessories)
- 6 products with prices ranging from Rp 599,000 to Rp 8,999,000
- 6 product images (one per product)

You can add more data or modify existing records as needed.
