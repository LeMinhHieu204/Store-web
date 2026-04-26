<?php $__env->startSection('content'); ?>
    <?php ($currentUser = auth()->user()); ?>

    <section class="page-section">
        <div class="section-head">
            <h1 class="section-title" style="margin-bottom:0;">Liên hệ</h1>
        </div>

        <div class="card" style="padding:24px;">
            <form method="POST" action="<?php echo e(route('user.contact.store')); ?>" class="stack-form">
                <?php echo csrf_field(); ?>

                <div style="display:grid; grid-template-columns:repeat(2, minmax(0, 1fr)); gap:16px;">
                    <label style="display:grid; gap:8px;">
                        <span style="font-weight:700; color:#17324d;">Họ tên</span>
                        <input
                            type="text"
                            name="name"
                            value="<?php echo e(old('name', $currentUser?->name)); ?>"
                            placeholder="Nhập họ tên"
                        >
                    </label>

                    <label style="display:grid; gap:8px;">
                        <span style="font-weight:700; color:#17324d;">Email</span>
                        <input
                            type="email"
                            name="email"
                            value="<?php echo e(old('email', $currentUser?->email)); ?>"
                            placeholder="Nhập email"
                        >
                    </label>
                </div>

                <label style="display:grid; gap:8px;">
                    <span style="font-weight:700; color:#17324d;">Nội dung cần hỗ trợ</span>
                    <textarea name="message" rows="7" placeholder="Mô tả vấn đề hoặc yêu cầu của bạn"><?php echo e(old('message')); ?></textarea>
                </label>

                <div style="display:flex; justify-content:flex-start;">
                    <button class="btn" type="submit">Gửi liên hệ</button>
                </div>
            </form>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\lemin\laragon\www\Webbanweb\resources\views/user/contact/index.blade.php ENDPATH**/ ?>