<?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <article class="card product-card" style="box-shadow:none;">
        <img class="thumb" src="<?php echo e(\Illuminate\Support\Str::startsWith($product->thumbnail, ['http://', 'https://']) ? $product->thumbnail : '/'.$product->thumbnail); ?>" alt="<?php echo e($product->title); ?>">
        <?php if($product->images->isNotEmpty()): ?>
            <div style="display:flex; gap:6px; overflow:auto;">
                <?php $__currentLoopData = $product->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <img src="<?php echo e(\Illuminate\Support\Str::startsWith($image->image_path, ['http://', 'https://']) ? $image->image_path : '/'.$image->image_path); ?>" alt="<?php echo e($product->title); ?>" style="width:48px; height:38px; object-fit:cover; border-radius:8px;">
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
        <h3><a href="<?php echo e(route('user.product.show', $product->slug)); ?>"><?php echo e($product->title); ?></a></h3>
        <p class="meta"><?php echo e($product->category->name); ?></p>
        <div style="display:flex; align-items:baseline; gap:10px; flex-wrap:wrap;">
            <?php if($product->has_discount): ?>
                <div class="meta" style="text-decoration:line-through;"><?php echo e(number_format($product->display_original_price)); ?> đ</div>
            <?php endif; ?>
            <p class="price"><?php echo e(number_format($product->display_sale_price)); ?> đ</p>
        </div>
        <a class="btn" href="<?php echo e(route('user.product.show', $product->slug)); ?>">Xem chi tiết</a>
    </article>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <p class="meta">Không tìm thấy sản phẩm phù hợp.</p>
<?php endif; ?>
<?php /**PATH D:\lemin\laragon\www\Webbanweb\resources\views/user/product/_cards.blade.php ENDPATH**/ ?>