<?php $__env->startSection('content'); ?>
    <section class="page-section">
        <h1 class="section-title">Đăng ký tài khoản</h1>
        <div class="card" style="max-width:560px; padding:20px;">
            <form class="stack-form" method="POST" action="<?php echo e(route('user.register.submit')); ?>">
                <?php echo csrf_field(); ?>
                <div style="display:grid; gap:6px;">
                    <input type="text" name="name" value="<?php echo e(old('name')); ?>" placeholder="Họ tên">
                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <small style="color:#be123c;"><?php echo e($message); ?></small>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div style="display:grid; gap:6px;">
                    <input type="email" name="email" value="<?php echo e(old('email')); ?>" placeholder="Email">
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <small style="color:#be123c;"><?php echo e($message); ?></small>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div style="display:grid; gap:6px;">
                    <input type="password" name="password" placeholder="Mật khẩu">
                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <small style="color:#be123c;"><?php echo e($message); ?></small>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div style="display:grid; gap:6px;">
                    <input type="password" name="password_confirmation" placeholder="Nhập lại mật khẩu">
                </div>
                <button class="btn">Tạo tài khoản</button>
            </form>
            <p class="meta" style="margin:16px 0 0;">
                Đã có tài khoản?
                <a href="<?php echo e(route('user.login')); ?>" style="color:var(--blue-deep); font-weight:700;">Đăng nhập</a>
            </p>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\lemin\laragon\www\Webbanweb\resources\views/user/auth/register.blade.php ENDPATH**/ ?>