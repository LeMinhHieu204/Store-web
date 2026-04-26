<?php $__env->startSection('content'); ?>
    <section class="page-section" style="display:grid; grid-template-columns:minmax(320px, 420px) 1fr; gap:20px;">
        <div class="card" style="padding:20px;">
            <h1 class="section-title" style="font-size:26px;">Thong tin tai khoan</h1>
            <div style="margin-bottom:16px; padding:16px; border-radius:16px; background:linear-gradient(135deg, #eff6ff, #eef2ff); border:1px solid #dbe8f5;">
                <div class="meta">So du hien tai</div>
                <div class="price" style="font-size:28px;"><?php echo e(number_format($user->balance)); ?> đ</div>
            </div>
            <form class="stack-form" method="POST" action="<?php echo e(route('user.profile.update')); ?>">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <input type="text" name="name" value="<?php echo e(old('name', $user->name)); ?>" placeholder="Ho ten">
                <input type="email" name="email" value="<?php echo e(old('email', $user->email)); ?>" placeholder="Email">
                <input type="password" name="password" placeholder="Mat khau moi (khong bat buoc)">
                <input type="password" name="password_confirmation" placeholder="Nhap lai mat khau moi">
                <button class="btn">Cap nhat tai khoan</button>
            </form>
        </div>

        <div style="display:grid; gap:20px;">
            <div class="card" style="padding:20px;">
                <div class="section-head">
                    <h2 class="section-title" style="font-size:26px;">Nap tien tu dong</h2>
                </div>
                <div style="display:grid; grid-template-columns:minmax(260px, 340px) 1fr; gap:20px;">
                    <form class="stack-form" method="POST" action="<?php echo e(route('user.topup.store')); ?>">
                        <?php echo csrf_field(); ?>
                        <input type="number" min="10000" step="1000" name="amount" placeholder="So tien muon nap">
                        <button class="btn">Tao lenh nap tien</button>
                    </form>
                    <div style="padding:16px; border:1px solid #dbe8f5; border-radius:16px; background:#f8fbff;">
                        <strong style="display:block; margin-bottom:10px;">Thong tin doi soat</strong>
                        <div class="meta" style="display:grid; gap:8px;">
                            <div>Ngan hang: <strong><?php echo e(env('TOPUP_BANK_NAME', 'MBBank')); ?></strong></div>
                            <div>Chu TK: <strong><?php echo e(env('TOPUP_BANK_ACCOUNT_NAME', 'WEB BAN SOURCE')); ?></strong></div>
                            <div>So TK: <strong><?php echo e(env('TOPUP_BANK_ACCOUNT_NUMBER', '0123456789')); ?></strong></div>
                            <div>Webhook: <strong><?php echo e(route('user.topup.callback')); ?></strong></div>
                            <div>API Key: <strong><?php echo e(env('TOPUP_CALLBACK_API_KEY', 'chua-cau-hinh')); ?></strong></div>
                            <div>Secret Key: <strong><?php echo e(env('TOPUP_CALLBACK_SECRET', 'changeme')); ?></strong></div>
                            <div>Auth API Key: <strong>Authorization: Apikey YOUR_TOKEN</strong></div>
                            <div>Auth Secret Key: <strong>X-Secret-Key: YOUR_SECRET</strong></div>
                            <div>Content-Type: <strong>application/json</strong></div>
                        </div>
                        <div class="meta" style="margin-top:12px; padding-top:12px; border-top:1px solid #dbe8f5; display:grid; gap:6px;">
                            <div>SePay URL: dung URL webhook o tren, nhung phai la domain public.</div>
                            <div>Neu dang chay Laragon voi <strong>localhost</strong>, SePay se khong goi duoc callback.</div>
                            <div>Ban can dung domain public/https hoac mo tam bang tunnel nhu ngrok/Cloudflare Tunnel.</div>
                        </div>
                        <?php if($latestDeposits->isNotEmpty()): ?>
                            <div style="margin-top:14px; padding-top:14px; border-top:1px solid #dbe8f5;">
                                <div class="meta" style="margin-bottom:8px;">Noi dung chuyen khoan goi y</div>
                                <strong><?php echo e($latestDeposits->first()->code); ?></strong>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div style="margin-top:16px; display:grid; gap:10px;">
                    <?php $__empty_1 = true; $__currentLoopData = $latestDeposits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deposit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div style="display:flex; justify-content:space-between; gap:14px; flex-wrap:wrap; padding:14px 16px; border:1px solid #dbe8f5; border-radius:14px;">
                            <div>
                                <strong><?php echo e($deposit->code); ?></strong>
                                <div class="meta"><?php echo e($deposit->created_at?->format('d/m/Y H:i')); ?></div>
                            </div>
                            <div style="text-align:right;">
                                <div class="price" style="font-size:20px;"><?php echo e(number_format($deposit->amount)); ?> đ</div>
                                <div class="meta">Trang thai: <strong><?php echo e(strtoupper($deposit->status)); ?></strong></div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="meta">Chua co giao dich nap tien nao.</div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card" style="padding:20px;">
                <div class="section-head">
                    <h2 class="section-title" style="font-size:26px;">Lich su mua hang</h2>
                </div>
                <div style="display:grid; gap:14px;">
                    <?php $__empty_1 = true; $__currentLoopData = $user->orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <article style="border:1px solid #dbe8f5; border-radius:16px; padding:16px;">
                            <div style="display:flex; justify-content:space-between; gap:14px; flex-wrap:wrap; margin-bottom:10px;">
                                <strong>Don #<?php echo e($order->id); ?></strong>
                                <span class="price" style="font-size:20px;"><?php echo e(number_format($order->total_price)); ?> đ</span>
                            </div>
                            <div style="display:grid; gap:10px;">
                                <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div style="display:flex; justify-content:space-between; gap:12px; flex-wrap:wrap; padding:12px; border-radius:12px; background:#f8fbff;">
                                        <div>
                                            <?php if($item->product): ?>
                                                <strong>
                                                    <a href="<?php echo e(route('user.product.show', $item->product->slug)); ?>" style="color:inherit; text-decoration:none;">
                                                        <?php echo e($item->product->title); ?>

                                                    </a>
                                                </strong>
                                            <?php else: ?>
                                                <strong>San pham khong con ton tai</strong>
                                            <?php endif; ?>
                                            <div class="meta"><?php echo e(number_format($item->price)); ?> đ</div>
                                        </div>
                                        <div>
                                            <?php if(in_array($item->product_id, $downloadableIds)): ?>
                                                <a class="btn secondary" href="<?php echo e(route('user.download', $item->product_id)); ?>">Tai file</a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </article>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="meta">Ban chua co don hang nao. Hay chon source code va thanh toan de bat dau.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\lemin\laragon\www\Webbanweb\resources\views/user/profile/index.blade.php ENDPATH**/ ?>