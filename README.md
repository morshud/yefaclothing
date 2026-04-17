# yefaclothing

A simple PHP site with a homepage and an account flow (login/register/logout) backed by a PDO database.

## Requirements

- PHP with the PDO extension enabled
  - SQLite: `pdo_sqlite`
  - MySQL: `pdo_mysql`

## Run locally (PHP built-in server)

From the project root:

```bash
php -S localhost:8000 -t public public/router.php
```

Open:

- http://localhost:8000/
- http://localhost:8000/login
- http://localhost:8000/my-account

Notes:

- `public/router.php` is for the PHP built-in dev server.
- On Apache (cPanel), clean URLs are handled by `.htaccess`.

## Configure the database

The app loads environment variables from a `.env` file at the project root (see `src/bootstrap.php`).

### Option A: SQLite (quickest)

1. Create an SQLite DB file (recommended location: `storage/`):

```bash
sqlite3 storage/app.sqlite < database/schema.sqlite.sql
```

2. Set your DSN in `.env`:

```env
YEFA_DB_DSN=sqlite:storage/app.sqlite
```

### Option B: MySQL

1. Create a database (example name: `yefaclothing`) and a DB user.
2. Import the schema:

```bash
mysql -u YOUR_USER -p yefaclothing < database/schema.mysql.sql
```

3. Set credentials in `.env`:

```env
YEFA_DB_DSN="mysql:host=127.0.0.1;dbname=yefaclothing;charset=utf8mb4"
YEFA_DB_USER=YOUR_USER
YEFA_DB_PASS=YOUR_PASSWORD
```

If your MySQL server uses a non-default port, add it to the DSN:

```env
YEFA_DB_DSN="mysql:host=127.0.0.1;port=3306;dbname=yefaclothing;charset=utf8mb4"
```

## Environment variables

- `YEFA_DB_DSN` (required)
- `YEFA_DB_USER` (required for MySQL)
- `YEFA_DB_PASS` (required for MySQL)

Optional (currently not required for the basic login/register flow):

- `YEFA_ADMIN_EMAIL`
- `YEFA_ADMIN_PASSWORD_HASH`

## Deploy to Wasmer

Two common differences on Wasmer vs localhost:

1) Your local `.env` file is **not** deployed if you deploy from git (it is in `.gitignore`).
2) Clean URLs like `/login` require URL rewriting (Wasmer setups often only serve real files like `/login.php` unless you configure a router).

### 1) Set environment variables (recommended)

In your Wasmer app settings, add these environment variables:

- `YEFA_DB_DSN` (required)
- `YEFA_DB_USER` (required for MySQL)
- `YEFA_DB_PASS` (required for MySQL)

Notes:

- In dashboards/UIs, paste the **raw value** (no surrounding quotes). Example DSN value:
  - `mysql:host=YOUR_HOST;port=3306;dbname=YOUR_DB;charset=utf8mb4`
- Make sure the runtime has the right PDO driver enabled (`pdo_mysql` for MySQL, `pdo_sqlite` for SQLite).

### 2) Clean URLs on Wasmer (optional)

If your Wasmer deployment runs the PHP built-in server, start it with the router script so extensionless URLs work:

```bash
php -S 0.0.0.0:$PORT -t public public/router.php
```

If you can’t enable rewriting/router support, use the `.php` URLs (e.g. `/login.php`, `/my-account.php`).

## Deploy to cPanel (Apache)

This project is designed to run at the domain root (not inside a subfolder like `/yefaclothing`) because redirects use absolute paths like `/login`.

### 1) Upload the files

Use File Manager or FTP to upload the project.

You have two common deployment options:

**Option A (recommended): set the domain document root to `public/`**

- Best for an Addon Domain or Subdomain.
- Upload the project to something like `yefaclothing/` in your home directory.
- In cPanel:
  - Addon Domain / Subdomain → set **Document Root** to `yefaclothing/public` (or the equivalent absolute path).

**Option B: keep the document root as `public_html/` and use the root `.htaccess`**

- Useful for the main domain when you cannot (or don’t want to) change Document Root.
- Upload the project contents directly into `public_html/` so `public/` exists as `public_html/public/`.
- The root `.htaccess` routes requests into `/public`.

Important:

- Make sure hidden files are uploaded (especially `.htaccess`). In cPanel File Manager, enable “Show Hidden Files (dotfiles)”.
- Clean URLs like `/login` require Apache `mod_rewrite` and `.htaccess` overrides enabled (typical on cPanel). If `/login.php` works but `/login` does not, this is the first thing to check.

### 2) Create `.env`

Create a `.env` file in the project root (same level as `src/`, `public/`, `database/`). Example (MySQL):

```env
YEFA_DB_DSN="mysql:host=127.0.0.1;dbname=cpanel_dbname;charset=utf8mb4"
YEFA_DB_USER=cpanel_dbuser
YEFA_DB_PASS=cpanel_dbpass
```

### 3) Create the database and import schema

**MySQL (typical on cPanel)**

1. cPanel → **MySQL Databases**
   - Create a database
   - Create a user
   - Add the user to the database (ALL PRIVILEGES)
2. cPanel → **phpMyAdmin**
   - Select your database
   - Import [database/schema.mysql.sql](database/schema.mysql.sql)

**SQLite (only if your hosting supports it)**

- Ensure `storage/` is writable.
- Create `storage/app.sqlite` and import [database/schema.sqlite.sql](database/schema.sqlite.sql).

### 4) Permissions

- If using SQLite, the `storage/` directory must be writable by PHP.
  - Typical permissions are `775` for `storage/` and `664` for `storage/app.sqlite`.

### 5) Verify

Visit:

- `/` (home)
- `/login` (register a new user or log in)
- `/my-account` (after login)

If you see “Database schema is missing”, import the schema file into your database.

## Project layout

- `public/` — web root (`index.php`, `login.php`, `my-account.php`, `router.php`, `.htaccess`)
- `src/` — bootstrap/config and shared helpers
- `src/partials/` — shared layout templates
- `database/` — SQL schemas
- `storage/` — writable runtime data (e.g., SQLite DB)
- `public/assets/` — static assets
