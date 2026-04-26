# Web Ban Source Code

Project web bán source code theo mô hình giống codedoan, tổ chức theo chuẩn Laravel MVC với frontend `user` và backend `admin` tách biệt.

## Cấu trúc chính

- `app/Http/Controllers/User`: controller cho trang public, tài khoản, tải file.
- `app/Http/Controllers/Admin`: controller cho dashboard và các module quản trị.
- `app/Http/Middleware/AdminMiddleware.php`: middleware chặn truy cập `/admin`.
- `resources/views/user`: giao diện frontend.
- `resources/views/admin`: giao diện backend.
- `routes/web.php`: route nhóm `user` và `admin`.
- `public/uploads`: nơi lưu ảnh và file `.zip` sản phẩm.
- `database.sql`: file import trực tiếp toàn bộ schema + seed data mẫu.

## Database mẫu

- Tên database: `web_ban_source`
- Tài khoản admin mẫu: `admin / admin123`
- Tài khoản user mẫu: `user / user123`

## Chạy trên Laragon

1. Bảo đảm Laragon có PHP đầy đủ và Composer hoạt động.
2. Trong thư mục project, chạy:

```bash
composer install
php artisan key:generate
```

3. Cách 1 dùng SQL có sẵn:

```bash
mysql -u root -p < database.sql
```

4. Cách 2 dùng migrate/seed:

```bash
php artisan migrate
php artisan db:seed
```

5. Tạo liên kết storage nếu muốn dùng upload theo disk `public`:

```bash
php artisan storage:link
```

6. Chạy project:

```bash
php artisan serve
```

Sau khi chạy:

- Frontend: `/`
- Login: `/login`
- Profile user: `/profile`
- Admin dashboard: `/admin/dashboard`

## Ghi chú môi trường hiện tại

Workspace này đã được scaffold theo cấu trúc Laravel mới, nhưng phiên làm việc hiện tại không có `php.exe` đầy đủ trong Laragon nên chưa thể chạy `composer install` hay test runtime trực tiếp từ đây. Toàn bộ route, controller, view, migration, seeder và `database.sql` đã được chuẩn bị để bạn đưa vào môi trường Laravel/Laragon đầy đủ là có thể hoàn thiện chạy thật nhanh.
