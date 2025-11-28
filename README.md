# Hướng Dẫn Cài Đặt Source Code

## Yêu Cầu Hệ Thống

Trước khi cài đặt, đảm bảo máy tính của bạn đã cài đặt các phần mềm sau:

- **PHP**: >= 8.2 (khuyến nghị PHP 8.2 hoặc cao hơn)
- **Composer**: Phiên bản mới nhất ([Tải Composer](https://getcomposer.org/download/))
- **Node.js**: >= 18.x và npm ([Tải Node.js](https://nodejs.org/))
- **Database**: Một trong các hệ quản trị cơ sở dữ liệu sau:
  - SQLite (mặc định, không cần cài đặt)
  - MySQL >= 5.7 hoặc MariaDB >= 10.3
  - PostgreSQL >= 10
  - SQL Server

## Các Bước Cài Đặt

### Bước 1: Clone Source Code

```bash
git clone <repository-url>
cd laravel-12
git checkout develop
```

### Bước 2: Cài Đặt PHP Dependencies

Cài đặt các thư viện PHP cần thiết bằng Composer:

```bash
composer install
```

### Bước 3: Cấu Hình Môi Trường

Tạo file `.env` từ file mẫu (nếu có) hoặc tạo mới:

```bash
# Trên Windows (Git Bash)
cp .env.example .env

# Hoặc tạo file .env mới và cấu hình thủ công
```

Cấu hình các thông tin trong file `.env`:

```env
APP_NAME=Laravel
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_TIMEZONE=UTC
APP_URL=http://localhost

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

APP_MAINTENANCE_DRIVER=file
APP_MAINTENANCE_STORE=database

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

# Cấu hình Database
# Nếu sử dụng SQLite (mặc định)
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite

# Hoặc nếu sử dụng MySQL
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=laravel
# DB_USERNAME=root
# DB_PASSWORD=

# Hoặc nếu sử dụng PostgreSQL
# DB_CONNECTION=pgsql
# DB_HOST=127.0.0.1
# DB_PORT=5432
# DB_DATABASE=laravel
# DB_USERNAME=root
# DB_PASSWORD=

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

CACHE_STORE=database
CACHE_PREFIX=

MEMCACHED_HOST=127.0.0.1

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=log
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

VITE_APP_NAME="${APP_NAME}"
```

### Bước 4: Tạo Application Key

Tạo key mã hóa cho ứng dụng:

```bash
php artisan key:generate
```

### Bước 5: Tạo Database 

### Bước 6: Chạy Migrations

Tạo các bảng trong database:

```bash
php artisan migrate
```

### Bước 7: Chạy Seeders (Tùy chọn)

Nạp dữ liệu mẫu vào database:

```bash
php artisan db:seed
```

Hoặc chạy từng seeder cụ thể:

```bash
php artisan db:seed --class=UserTableSeeder
php artisan db:seed --class=RoleTableSeeder
php artisan db:seed --class=PermissionTableSeeder
php artisan db:seed --class=StorageSeeder
php artisan db:seed --class=CategorySeeder
php artisan db:seed --class=ProductSeeder
```

### Bước 8: Cài Đặt Node Dependencies (Nếu có)

Nếu project có sử dụng frontend assets:

```bash
npm install
```

### Bước 9: Tạo Symbolic Link cho Storage

Tạo liên kết từ `storage/app/public` đến `public/storage`:

```bash
php artisan storage:link
```

### Bước 10: Phân Quyền Thư Mục (Linux/Mac)

Trên Linux hoặc Mac, đảm bảo các thư mục có quyền ghi:

```bash
chmod -R 775 storage bootstrap/cache
```

### Bước 11: Chạy Ứng Dụng

Khởi động server development:

```bash
php artisan serve
```

Ứng dụng sẽ chạy tại: `http://localhost:8000`

## Cài Đặt Nhanh (Sử dụng Script)

Bạn có thể sử dụng script tự động có sẵn trong `composer.json`:

```bash
composer run setup
```

Script này sẽ tự động:
- Cài đặt Composer dependencies
- Tạo file `.env` nếu chưa có
- Tạo application key
- Chạy migrations
- Cài đặt npm packages
- Build assets

## Chạy Development Server với Queue và Logs

Để chạy server kèm queue worker và logs:

```bash
composer run dev
```

Lệnh này sẽ chạy:
- Laravel development server
- Queue worker
- Pail (log viewer)
- Vite dev server (nếu có)


## Kiểm Tra Cài Đặt

Sau khi cài đặt, kiểm tra bằng cách:

1. Truy cập `http://localhost:8000` - trang chủ Laravel
2. Chạy test:
```bash
php artisan test
```

## Xử Lý Lỗi Thường Gặp

### Lỗi: "SQLSTATE[HY000] [2002] No connection could be made"

- Kiểm tra database server đã chạy chưa
- Kiểm tra thông tin kết nối trong file `.env`

### Lỗi: "The stream or file could not be opened"

- Đảm bảo thư mục `storage/logs` có quyền ghi
- Chạy: `chmod -R 775 storage` (Linux/Mac)

### Lỗi: "Class not found"

- Chạy lại: `composer dump-autoload`
- Xóa cache: `php artisan config:clear && php artisan cache:clear`

### Lỗi: "APP_KEY is not set"

- Chạy: `php artisan key:generate`

## Cấu Trúc Database

Project này bao gồm các bảng sau:

- `users` - Người dùng
- `permissions` - Quyền hạn
- `roles` - Vai trò
- `model_has_permissions` - Quyền của model
- `model_has_roles` - Vai trò của model
- `role_has_permissions` - Quyền của vai trò
- `storages` - Kho hàng
- `categories` - Danh mục
- `products` - Sản phẩm
- `personal_access_tokens` - Token API (Sanctum)
- `cache` - Cache
- `cache_locks` - Cache locks
- `jobs` - Queue jobs
- `job_batches` - Queue job batches
- `failed_jobs` - Jobs thất bại

## Thông Tin Bổ Sung

- **Framework**: Laravel 12
- **PHP Version**: >= 8.2
- **Authentication**: Laravel Sanctum
- **Permissions**: Spatie Laravel Permission
- **API Documentation**: Scramble

## Liên Hệ Hỗ Trợ

Nếu gặp vấn đề trong quá trình cài đặt, vui lòng liên hệ team phát triển.

