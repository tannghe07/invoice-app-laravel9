# Docker Setup for Laravel Invoices App

## Yêu cầu
- Docker
- Docker Compose

## Cách sử dụng

### 1. Khởi động container
```bash
docker-compose up -d
```

### 2. Chạy migration
```bash
docker-compose exec app php artisan migrate
```

### 3. Chạy seeder (nếu có)
```bash
docker-compose exec app php artisan db:seed
```

### 4. Tạo storage symlink
```bash
docker-compose exec app php artisan storage:link
```

## Truy cập ứng dụng
- **Ứng dụng**: http://localhost
- **MySQL**: localhost:3306
  - User: laravel
  - Password: password
  - Database: invoices_db

## Lệnh hữu ích

### Xem logs
```bash
docker-compose logs -f app
```

### Truy cập PHP container
```bash
docker-compose exec app bash
```

### Truy cập MySQL
```bash
docker-compose exec db mysql -u laravel -p invoices_db
```

### Dừng container
```bash
docker-compose down
```

### Xóa volume (xóa dữ liệu)
```bash
docker-compose down -v
```

## Cấu hình Database trong .env
```
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=invoices_db
DB_USERNAME=laravel
DB_PASSWORD=password
```

## Cấu trúc file
- `Dockerfile` - Build PHP-FPM image
- `docker-compose.yml` - Orchestrate services
- `nginx.conf` - Nginx configuration
- `.dockerignore` - Files to exclude from build
