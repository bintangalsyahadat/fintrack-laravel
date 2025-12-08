# Laravel FinTrack

A brief description of your Laravel application.

## System Requirements

- PHP >= 8.1
- Composer
- MySQL/PostgreSQL/SQLite
- Node.js (+22) & NPM (for asset compilation)
- Git

## Installation

Follow these steps to setup the Laravel project locally:

### 1. Clone Repository
```bash
git clone https://github.com/bintangalsyahadat/fintrack-laravel.git
cd fintrack-laravel
```

### 2. Install PHP Dependencies
```bash
composer install
```

### 3. Environment Setup

Copy the `.env.example` file to `.env`:
```bash
cp .env.example .env
```

Then edit the `.env` file and configure your database settings:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=fintrack
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generate Application Key
```bash
php artisan key:generate
```

### 5. Create Database

Create a new database matching the name in your `.env` file:
```sql
CREATE DATABASE fintrack;
```

### 6. Run Database Migrations
```bash
php artisan migrate
```

If you have seeders, run:
```bash
php artisan db:seed
```

Or run both together:
```bash
php artisan migrate --seed
```

### 7. Install Node.js Dependencies

If the project uses Vite or Laravel Mix:
```bash
npm install
```

Build assets:
```bash
npm run build
```

### 8. Create Storage Link
```bash
php artisan storage:link
```

### 9. Set Permissions (Linux/Mac)
```bash
chmod -R 775 storage bootstrap/cache
```

### 10. Start Development Server
```bash
php artisan serve
```

The application will be available at `http://localhost:8000`

## Contributing

Feel free to submit pull requests or report issues if you find any bugs.

## License

[MIT License](LICENSE)
