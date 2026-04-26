DROP DATABASE IF EXISTS web_ban_source;
CREATE DATABASE web_ban_source CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE web_ban_source;

CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') NOT NULL DEFAULT 'user',
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE categories (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    image_path VARCHAR(255) NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE products (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    description LONGTEXT NOT NULL,
    original_price DECIMAL(12,2) NULL DEFAULT NULL,
    price DECIMAL(12,2) NOT NULL DEFAULT 0,
    thumbnail VARCHAR(255) NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    category_id BIGINT UNSIGNED NOT NULL,
    is_featured TINYINT(1) NOT NULL DEFAULT 0,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_products_category FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);

CREATE TABLE product_images (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    product_id BIGINT UNSIGNED NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_product_images_product FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

CREATE TABLE orders (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    total_price DECIMAL(12,2) NOT NULL DEFAULT 0,
    status ENUM('pending', 'paid', 'completed', 'cancelled') NOT NULL DEFAULT 'pending',
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_orders_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE order_items (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    order_id BIGINT UNSIGNED NOT NULL,
    product_id BIGINT UNSIGNED NOT NULL,
    price DECIMAL(12,2) NOT NULL DEFAULT 0,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_order_items_order FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    CONSTRAINT fk_order_items_product FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

CREATE TABLE posts (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content LONGTEXT NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE contacts (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO users (id, name, email, password, role, created_at, updated_at) VALUES
(1, 'admin', 'admin@example.com', 'admin123', 'admin', NOW(), NOW()),
(2, 'user', 'user@example.com', 'user123', 'user', NOW(), NOW());

INSERT INTO categories (id, name, slug, image_path, created_at, updated_at) VALUES
(1, 'Laravel', 'laravel', 'uploads/categories/laravel.jpg', NOW(), NOW()),
(2, 'WordPress', 'wordpress', 'uploads/categories/wordpress.jpg', NOW(), NOW()),
(3, 'React', 'react', 'uploads/categories/react.jpg', NOW(), NOW());

INSERT INTO products (id, title, slug, description, original_price, price, thumbnail, file_path, category_id, is_featured, created_at, updated_at) VALUES
(1, 'Marketplace Laravel Pro', 'marketplace-laravel-pro', 'Bo source code ban hang so voi dashboard, thanh toan va phan quyen.', 1090000, 890000, 'uploads/products/laravel-pro.jpg', 'uploads/products/marketplace-laravel-pro.zip', 1, 1, NOW(), NOW()),
(2, 'Blog WordPress Premium', 'blog-wordpress-premium', 'Giao dien blog chuan SEO, de tuy bien, toi uu toc do tai.', 590000, 490000, 'uploads/products/wp-blog.jpg', 'uploads/products/blog-wordpress-premium.zip', 2, 0, NOW(), NOW()),
(3, 'Admin Panel React', 'admin-panel-react', 'Template React admin panel dung cho dashboard SaaS hien dai.', 790000, 690000, 'uploads/products/react-admin.jpg', 'uploads/products/admin-panel-react.zip', 3, 1, NOW(), NOW());

INSERT INTO product_images (id, product_id, image_path, created_at, updated_at) VALUES
(1, 1, 'uploads/products/gallery/laravel-pro-1.jpg', NOW(), NOW()),
(2, 1, 'uploads/products/gallery/laravel-pro-2.jpg', NOW(), NOW()),
(3, 2, 'uploads/products/gallery/wp-blog-1.jpg', NOW(), NOW()),
(4, 3, 'uploads/products/gallery/react-admin-1.jpg', NOW(), NOW());

INSERT INTO orders (id, user_id, total_price, status, created_at, updated_at) VALUES
(1, 2, 890000, 'completed', NOW(), NOW()),
(2, 2, 490000, 'paid', NOW(), NOW());

INSERT INTO order_items (id, order_id, product_id, price, created_at, updated_at) VALUES
(1, 1, 1, 890000, NOW(), NOW()),
(2, 2, 2, 490000, NOW(), NOW());

INSERT INTO posts (id, title, content, slug, created_at, updated_at) VALUES
(1, 'Kinh nghiem chon source code ban hang', 'Bai viet chia se cach chon source code phu hop voi mo hinh kinh doanh.', 'kinh-nghiem-chon-source-code-ban-hang', NOW(), NOW()),
(2, 'Cac buoc trien khai source code tren Laragon', 'Huong dan cau hinh Apache, MySQL va virtual host tren Laragon.', 'cac-buoc-trien-khai-source-code-tren-laragon', NOW(), NOW());

INSERT INTO contacts (id, name, email, message, created_at, updated_at) VALUES
(1, 'Le Minh', 'minh@example.com', 'Minh can tu van source code cho website ban khoa hoc.', NOW(), NOW()),
(2, 'Tran An', 'an@example.com', 'Cho minh hoi cach cap nhat phien ban moi cua source.', NOW(), NOW());
