<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Contact;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Post;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::insert([
            [
                'id' => 1,
                'name' => 'admin',
                'email' => 'admin@example.com',
                'password' => 'admin123',
                'role' => 'admin',
                'balance' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'user',
                'email' => 'user@example.com',
                'password' => 'user123',
                'role' => 'user',
                'balance' => 1500000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        Category::insert([
            ['id' => 1, 'name' => 'Laravel', 'slug' => 'laravel', 'image_path' => 'uploads/categories/laravel.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'WordPress', 'slug' => 'wordpress', 'image_path' => 'uploads/categories/wordpress.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'React', 'slug' => 'react', 'image_path' => 'uploads/categories/react.jpg', 'created_at' => now(), 'updated_at' => now()],
        ]);

        Product::insert([
            [
                'id' => 1,
                'title' => 'Marketplace Laravel Pro',
                'slug' => 'marketplace-laravel-pro',
                'description' => 'Bo source code ban hang so voi dashboard, thanh toan va phan quyen.',
                'original_price' => 1090000,
                'price' => 890000,
                'thumbnail' => 'uploads/products/laravel-pro.jpg',
                'file_path' => 'uploads/products/marketplace-laravel-pro.zip',
                'category_id' => 1,
                'is_featured' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'title' => 'Blog WordPress Premium',
                'slug' => 'blog-wordpress-premium',
                'description' => 'Giao dien blog chuan SEO, de tuy bien, toi uu toc do tai.',
                'original_price' => 590000,
                'price' => 490000,
                'thumbnail' => 'uploads/products/wp-blog.jpg',
                'file_path' => 'uploads/products/blog-wordpress-premium.zip',
                'category_id' => 2,
                'is_featured' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'title' => 'Admin Panel React',
                'slug' => 'admin-panel-react',
                'description' => 'Template React admin panel dung cho dashboard SaaS hien dai.',
                'original_price' => 790000,
                'price' => 690000,
                'thumbnail' => 'uploads/products/react-admin.jpg',
                'file_path' => 'uploads/products/admin-panel-react.zip',
                'category_id' => 3,
                'is_featured' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        ProductImage::insert([
            ['product_id' => 1, 'image_path' => 'uploads/products/gallery/laravel-pro-1.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['product_id' => 1, 'image_path' => 'uploads/products/gallery/laravel-pro-2.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['product_id' => 2, 'image_path' => 'uploads/products/gallery/wp-blog-1.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['product_id' => 3, 'image_path' => 'uploads/products/gallery/react-admin-1.jpg', 'created_at' => now(), 'updated_at' => now()],
        ]);

        Order::insert([
            ['id' => 1, 'user_id' => 2, 'total_price' => 890000, 'status' => 'completed', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'user_id' => 2, 'total_price' => 490000, 'status' => 'paid', 'created_at' => now(), 'updated_at' => now()],
        ]);

        OrderItem::insert([
            ['id' => 1, 'order_id' => 1, 'product_id' => 1, 'price' => 890000, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'order_id' => 2, 'product_id' => 2, 'price' => 490000, 'created_at' => now(), 'updated_at' => now()],
        ]);

        Post::insert([
            ['id' => 1, 'title' => 'Kinh nghiem chon source code ban hang', 'slug' => 'kinh-nghiem-chon-source-code-ban-hang', 'content' => 'Bai viet chia se cach chon source code phu hop voi mo hinh kinh doanh.', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'title' => 'Cac buoc trien khai source code tren Laragon', 'slug' => 'cac-buoc-trien-khai-source-code-tren-laragon', 'content' => 'Huong dan cau hinh Apache, MySQL va virtual host tren Laragon.', 'created_at' => now(), 'updated_at' => now()],
        ]);

        Contact::insert([
            ['id' => 1, 'name' => 'Le Minh', 'email' => 'minh@example.com', 'message' => 'Minh can tu van source code cho website ban khoa hoc.', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Tran An', 'email' => 'an@example.com', 'message' => 'Cho minh hoi cach cap nhat phien ban moi cua source.', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
