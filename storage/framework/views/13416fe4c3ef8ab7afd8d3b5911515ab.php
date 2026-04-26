<?php $__env->startSection('content'); ?>
    <section class="page-section card" style="padding:20px;">
        <div class="section-head">
            <h1 class="section-title">Giỏ hàng</h1>
            <a class="section-link" href="<?php echo e(route('user.products')); ?>">Tiếp tục mua sắm</a>
        </div>

        <?php if($cartItems->isEmpty()): ?>
            <p class="meta">Giỏ hàng hiện đang trống. Hãy thêm sản phẩm trước khi thanh toán.</p>
        <?php else: ?>
            <div style="display:grid; gap:14px;">
                <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <article style="display:grid; grid-template-columns:120px 1fr auto; gap:16px; align-items:center; padding:16px; border:1px solid #dbe8f5; border-radius:16px;">
                        <img src="<?php echo e(\Illuminate\Support\Str::startsWith($item['product']->thumbnail, ['http://', 'https://']) ? $item['product']->thumbnail : '/'.$item['product']->thumbnail); ?>" alt="<?php echo e($item['product']->title); ?>" style="width:120px; height:90px; object-fit:cover; border-radius:12px;">
                        <div>
                            <h3 style="margin:0 0 8px;"><?php echo e($item['product']->title); ?></h3>
                            <div class="meta"><?php echo e($item['product']->category->name); ?></div>
                            <div style="margin-top:8px;">
                                <?php if($item['product']->has_discount): ?>
                                    <div class="meta" style="text-decoration:line-through;"><?php echo e(number_format($item['product']->display_original_price)); ?> đ</div>
                                <?php endif; ?>
                                <div class="price" style="font-size:20px;"><?php echo e(number_format($item['product']->display_sale_price)); ?> đ</div>
                            </div>
                        </div>
                        <div style="display:grid; gap:10px; justify-items:end;">
                            <form method="POST" action="<?php echo e(route('user.cart.update', $item['product'])); ?>" style="display:flex; gap:8px; align-items:center;">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PATCH'); ?>
                                <input type="number" min="1" max="10" name="quantity" value="<?php echo e($item['quantity']); ?>" style="width:80px; padding:10px 12px;">
                                <button class="btn secondary">Cập nhật</button>
                            </form>
                            <form method="POST" action="<?php echo e(route('user.cart.remove', $item['product'])); ?>">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button class="btn">Xóa</button>
                            </form>
                        </div>
                    </article>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <div style="display:flex; justify-content:space-between; gap:16px; align-items:center; flex-wrap:wrap; margin-top:20px; padding-top:18px; border-top:1px solid #dbe8f5;">
                <div>
                    <div class="meta">Tổng thanh toán</div>
                    <div class="price" style="font-size:28px;"><?php echo e(number_format($cartTotal)); ?> đ</div>
                </div>
                <?php if(auth()->guard()->check()): ?>
                    <form method="POST" action="<?php echo e(route('user.checkout')); ?>">
                        <?php echo csrf_field(); ?>
                        <button class="btn">Thanh toán ngay</button>
                    </form>
                <?php else: ?>
                    <a class="btn" href="<?php echo e(route('user.login')); ?>">Đăng nhập để thanh toán</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\lemin\laragon\www\Webbanweb\resources\views/user/cart/index.blade.php ENDPATH**/ ?>