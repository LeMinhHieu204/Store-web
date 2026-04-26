<?php $__env->startSection('content'); ?>
    <div class="page-head">
        <div>
            <h1>Bài viết</h1>
            <p>Quản lý nội dung hiển thị và tin tức trong hệ thống.</p>
        </div>
        <div class="inline">
            <span class="toolbar-meta"><?php echo e($posts->count()); ?> bài viết</span>
            <button class="btn" type="button" onclick="document.getElementById('post-create-modal').classList.add('open')">Tạo mới</button>
        </div>
    </div>

    <div id="post-create-modal" class="modal-backdrop" onclick="if(event.target===this)this.classList.remove('open')">
        <div class="modal-card">
            <div class="modal-head">
                <h2>Tạo bài viết</h2>
                <button class="close-btn" type="button" onclick="document.getElementById('post-create-modal').classList.remove('open')">Đóng</button>
            </div>
            <form method="POST" action="<?php echo e(route('admin.posts.store')); ?>">
                <?php echo csrf_field(); ?>
                <label class="field-label">
                    <span>Tiêu đề</span>
                    <input type="text" name="title" placeholder="Tiêu đề bài viết">
                </label>
                <label class="field-label">
                    <span>Nội dung</span>
                    <textarea name="content" rows="5" placeholder="Nội dung bài viết"></textarea>
                </label>
                <button class="btn">Thêm bài viết</button>
            </form>
        </div>
    </div>

    <div class="table-wrap">
        <div class="table-head">
            <h3>Danh sách bài viết</h3>
            <span class="table-chip">Content</span>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Tiêu đề</th>
                    <th>Slug</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td>
                            <div class="cell-title"><?php echo e($post->title); ?></div>
                            <div class="muted"><?php echo e(\Illuminate\Support\Str::limit($post->content, 80)); ?></div>
                        </td>
                        <td class="muted"><?php echo e($post->slug); ?></td>
                        <td>
                            <form method="POST" action="<?php echo e(route('admin.posts.destroy', $post)); ?>" data-confirm-message="Bạn có chắc chắn muốn xóa bài viết này không?">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button class="btn danger">Xóa</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="3" class="muted">Chưa có bài viết nào.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\lemin\laragon\www\Webbanweb\resources\views/admin/posts/index.blade.php ENDPATH**/ ?>