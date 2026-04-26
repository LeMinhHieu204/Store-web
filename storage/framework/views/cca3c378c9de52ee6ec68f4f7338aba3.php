<?php $__env->startSection('content'); ?>
    <div class="page-head">
        <div>
            <h1>Danh mục</h1>
            <p>Quản lý nhóm sản phẩm và ảnh đại diện cho từng danh mục.</p>
        </div>
        <div class="inline">
            <span class="toolbar-meta"><?php echo e($categories->count()); ?> danh mục</span>
            <button class="btn" type="button" onclick="document.getElementById('category-create-modal').classList.add('open')">Tạo mới</button>
        </div>
    </div>

    <div id="category-create-modal" class="modal-backdrop" onclick="if(event.target===this)this.classList.remove('open')">
        <div class="modal-card">
            <div class="modal-head">
                <h2>Tạo danh mục</h2>
                <button class="close-btn" type="button" onclick="document.getElementById('category-create-modal').classList.remove('open')">Đóng</button>
            </div>
            <form method="POST" action="<?php echo e(route('admin.categories.store')); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <label class="field-label">
                    <span>Tên danh mục</span>
                    <input type="text" name="name" value="<?php echo e(old('name')); ?>" placeholder="Tên danh mục">
                </label>
                <label class="field-label">
                    <span>Ảnh đại diện</span>
                    <input type="file" name="image" accept="image/*">
                </label>
                <button class="btn">Thêm danh mục</button>
            </form>
        </div>
    </div>

    <div class="table-wrap">
        <div class="table-head">
            <h3>Danh sách danh mục</h3>
            <span class="table-chip">Quản lý nhanh</span>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Ảnh</th>
                    <th>Tên</th>
                    <th>Slug</th>
                    <th>Sản phẩm</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td>
                            <?php if($category->image_path): ?>
                                <img class="data-thumb" src="<?php echo e(\Illuminate\Support\Str::startsWith($category->image_path, ['http://', 'https://']) ? $category->image_path : '/'.$category->image_path); ?>" alt="<?php echo e($category->name); ?>">
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="cell-title"><?php echo e($category->name); ?></div>
                        </td>
                        <td class="muted"><?php echo e($category->slug); ?></td>
                        <td><?php echo e($category->products_count); ?></td>
                        <td>
                            <div class="inline">
                                <button class="btn secondary" type="button" onclick="document.getElementById('category-edit-modal-<?php echo e($category->id); ?>').classList.add('open')">Sửa</button>
                                <form method="POST" action="<?php echo e(route('admin.categories.destroy', $category)); ?>" data-confirm-message="Bạn có chắc chắn muốn xóa danh mục này không?">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button class="btn danger">Xóa</button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    <div id="category-edit-modal-<?php echo e($category->id); ?>" class="modal-backdrop" onclick="if(event.target===this)this.classList.remove('open')">
                        <div class="modal-card">
                            <div class="modal-head">
                                <h2>Cập nhật danh mục</h2>
                                <button class="close-btn" type="button" onclick="document.getElementById('category-edit-modal-<?php echo e($category->id); ?>').classList.remove('open')">Đóng</button>
                            </div>
                            <form method="POST" action="<?php echo e(route('admin.categories.update', $category)); ?>" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PUT'); ?>
                                <label class="field-label">
                                    <span>Tên danh mục</span>
                                    <input type="text" name="name" value="<?php echo e($category->name); ?>" placeholder="Tên danh mục">
                                </label>
                                <label class="field-label">
                                    <span>Slug hiện tại</span>
                                    <input type="text" value="<?php echo e($category->slug); ?>" disabled>
                                </label>
                                <?php if($category->image_path): ?>
                                    <div class="field-label">
                                        <span>Ảnh hiện tại</span>
                                        <img class="data-thumb" src="<?php echo e(\Illuminate\Support\Str::startsWith($category->image_path, ['http://', 'https://']) ? $category->image_path : '/'.$category->image_path); ?>" alt="<?php echo e($category->name); ?>">
                                    </div>
                                <?php endif; ?>
                                <label class="field-label">
                                    <span>Ảnh đại diện mới</span>
                                    <input type="file" name="image" accept="image/*">
                                </label>
                                <button class="btn">Lưu thay đổi</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="muted">Chưa có danh mục nào.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\lemin\laragon\www\Webbanweb\resources\views/admin/categories/index.blade.php ENDPATH**/ ?>