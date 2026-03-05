# SmartSpecs 📱

A database-driven smartphone comparison website built with PHP + MySQL.
Apple-inspired design · 24 latest flagships · Full specs database

---

## Project Structure

```
smartspecs/
│
├── index.php                  ← Front controller (router)
│
├── config/
│   ├── app.php                ← App constants (APP_NAME, APP_URL, etc.)
│   └── database.php           ← DB credentials + PDO singleton
│
├── data/
│   └── schema.sql             ← Full DB schema + seed data (run once)
│
├── includes/
│   ├── PhoneModel.php         ← All DB queries (brands, phones, specs)
│   ├── helpers.php            ← Utility functions (e(), url(), etc.)
│   ├── header.php             ← HTML <head> + navigation partial
│   ├── footer.php             ← Footer + closing tags partial
│   └── phone-card.php         ← Reusable phone card component
│
├── pages/
│   ├── home.php               ← Homepage
│   ├── brand.php              ← Brand page (3×2 phone grid)
│   ├── phone.php              ← Individual phone specs page
│   └── search.php             ← Search results page
│
└── assets/
    ├── css/
    │   └── main.css           ← All styles
    ├── js/
    │   └── main.js            ← UI interactions
    └── images/                ← Phone images go here (see below)
```

---

## Setup Instructions

### 1. Requirements
- PHP 8.1+
- MySQL 8.0+ (or MariaDB 10.6+)
- Apache / Nginx with mod_rewrite (or PHP built-in server for dev)

### 2. Database Setup

```bash
# Create DB and import schema + seed data
mysql -u root -p < data/schema.sql
```

### 3. Configure

Edit `config/database.php`:
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'smartspecs');
define('DB_USER', 'your_username');
define('DB_PASS', 'your_password');
```

Edit `config/app.php`:
```php
define('APP_URL', 'http://localhost/smartspecs');
```

### 4. Run (development)

```bash
cd smartspecs
php -S localhost:8000
# Visit: http://localhost:8000
```

### 5. Phone Images

Place your phone images in `assets/images/` using these filenames:

| Phone                   | Filename                    |
|-------------------------|-----------------------------|
| Samsung Galaxy S25 Ultra| `samsung_s25ultra.png`      |
| Samsung Galaxy S25+     | `samsung_s25plus.png`       |
| Samsung Galaxy S25      | `samsung_s25.png`           |
| Samsung Z Fold 6        | `samsung_zfold6.png`        |
| Samsung Z Flip 6        | `samsung_zflip6.png`        |
| Samsung Galaxy A55      | `samsung_a55.png`           |
| iPhone 16 Pro Max       | `iphone16promax.png`        |
| iPhone 16 Pro           | `iphone16pro.png`           |
| iPhone 16 Plus          | `iphone16plus.png`          |
| iPhone 16               | `iphone16.png`              |
| iPhone SE (4th gen)     | `iphone_se4.png`            |
| iPhone 15               | `iphone15.png`              |
| Xiaomi 15 Ultra         | `xiaomi15ultra.png`         |
| Xiaomi 15 Pro           | `xiaomi15pro.png`           |
| Xiaomi 15               | `xiaomi15.png`              |
| Xiaomi 14 Ultra         | `xiaomi14ultra.png`         |
| Xiaomi MIX Fold 4       | `xiaomi_mixfold4.png`       |
| Redmi Note 14 Pro+      | `redmi_note14pro.png`       |
| Pixel 9 Pro Fold        | `pixel9profold.png`         |
| Pixel 9 Pro XL          | `pixel9proxl.png`           |
| Pixel 9 Pro             | `pixel9pro.png`             |
| Pixel 9                 | `pixel9.png`                |
| Pixel 9a                | `pixel9a.png`               |
| Pixel 8 Pro             | `pixel8pro.png`             |

> If an image is missing, the site shows a stylized placeholder automatically.

---

## URL Structure

| URL                                  | Page             |
|--------------------------------------|------------------|
| `index.php`                          | Home             |
| `index.php?page=brand&brand=samsung` | Samsung brand    |
| `index.php?page=brand&brand=apple`   | Apple brand      |
| `index.php?page=brand&brand=xiaomi`  | Xiaomi brand     |
| `index.php?page=brand&brand=google`  | Google brand     |
| `index.php?page=phone&id=samsung_s25ultra` | Phone specs |
| `index.php?page=search&q=pixel`      | Search results   |

---

## Adding More Specs

To add full specs for phones (beyond the 4 sample phones in schema.sql),
follow this SQL pattern in `data/schema.sql`:

```sql
SET @pid = 'phone_id_here';
INSERT INTO spec_sections (phone_id, title, sort_order) VALUES
  (@pid, 'Display', 1),
  (@pid, 'Performance', 2);

SET @s = (SELECT id FROM spec_sections WHERE phone_id=@pid AND title='Display');
INSERT INTO spec_rows (section_id, spec_key, spec_value, sort_order) VALUES
  (@s, 'Screen Size', '6.7 inches', 1),
  (@s, 'Technology',  'AMOLED',     2);
```
