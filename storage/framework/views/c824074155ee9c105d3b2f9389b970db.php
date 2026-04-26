<?php $__env->startSection('content'); ?>
    <?php if($errors->any()): ?>
        <div class="card" style="margin-bottom:18px; color:#fca5a5;">
            <?php echo e($errors->first()); ?>

        </div>
    <?php endif; ?>

    <div class="page-head">
        <div>
            <h1>San pham</h1>
            <p>Quan ly source code, gia ban va hinh anh hien thi.</p>
        </div>
        <div class="inline">
            <span class="toolbar-meta"><?php echo e($products->total()); ?> san pham</span>
            <button class="btn" type="button" onclick="document.getElementById('product-create-modal').classList.add('open')">Tao moi</button>
        </div>
    </div>

    <div id="product-create-modal" class="modal-backdrop" onclick="if(event.target===this)this.classList.remove('open')">
        <div class="modal-card">
            <div class="modal-head">
                <h2>Tao san pham</h2>
                <button class="close-btn" type="button" onclick="document.getElementById('product-create-modal').classList.remove('open')">Dong</button>
            </div>
            <form method="POST" action="<?php echo e(route('admin.products.store')); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <label class="field-label">
                    <span>Ten san pham</span>
                    <input type="text" name="title" value="<?php echo e(old('title')); ?>" placeholder="Nhap ten san pham">
                </label>
                <label class="field-label">
                    <span>Mo ta</span>
                    <div class="inline" style="gap:8px;">
                        <button class="btn secondary js-format-btn" type="button" data-target="create-product-description" data-prefix="**" data-suffix="**">B</button>
                        <button class="btn secondary js-format-btn" type="button" data-target="create-product-description" data-prefix="*" data-suffix="*">I</button>
                        <button class="btn secondary js-format-btn" type="button" data-target="create-product-description" data-prefix="++" data-suffix="++">U</button>
                    </div>
                    <textarea id="create-product-description" name="description" rows="4" placeholder="Nhap mo ta"><?php echo e(old('description')); ?></textarea>
                    <small class="muted">Ho tro: **dam**, *nghieng*, ++gach chan++, va xuong dong.</small>
                </label>
                <div class="inline">
                    <label class="field-label" style="flex:1 1 220px;">
                        <span>Gia goc</span>
                        <input type="number" name="original_price" value="<?php echo e(old('original_price')); ?>" placeholder="Nhap gia goc">
                    </label>
                    <label class="field-label" style="flex:1 1 220px;">
                        <span>Gia ban</span>
                        <input type="number" name="price" value="<?php echo e(old('price')); ?>" placeholder="Nhap gia ban">
                    </label>
                    <label class="field-label" style="flex:1 1 220px;">
                        <span>Danh muc</span>
                        <select name="category_id">
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($category->id); ?>" <?php if((string) old('category_id') === (string) $category->id): echo 'selected'; endif; ?>><?php echo e($category->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </label>
                </div>
                <div class="inline" style="align-items:flex-start;">
                    <label class="field-label" style="flex:1 1 220px;">
                        <span>Anh dai dien</span>
                        <input type="file" name="thumbnail" accept="image/*">
                    </label>
                    <label class="field-label" style="flex:1 1 220px;">
                        <span>Anh gallery</span>
                        <input type="file" name="gallery_images[]" accept="image/*" multiple>
                    </label>
                    <label class="field-label" style="flex:1 1 220px;">
                        <span>File source (.zip)</span>
                        <input type="file" name="source_zip" accept=".zip">
                    </label>
                </div>
                <label class="field-label" style="display:flex; align-items:center; gap:10px;">
                    <input type="checkbox" name="is_featured" value="1" style="width:auto;" <?php if(old('is_featured')): echo 'checked'; endif; ?>>
                    <span>Danh dau san pham noi bat</span>
                </label>
                <button class="btn">Them san pham</button>
            </form>
        </div>
    </div>

    <div class="table-wrap">
        <div class="table-head">
            <h3>Danh sach san pham</h3>
            <span class="table-chip">Trang <?php echo e($products->currentPage()); ?> / <?php echo e($products->lastPage()); ?></span>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Anh</th>
                    <th>San pham</th>
                    <th>Danh muc</th>
                    <th>Gia ban</th>
                    <th>Noi bat</th>
                    <th>Thao tac</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td>
                            <img class="data-thumb" src="<?php echo e(\Illuminate\Support\Str::startsWith($product->thumbnail, ['http://', 'https://']) ? $product->thumbnail : '/'.$product->thumbnail); ?>" alt="<?php echo e($product->title); ?>">
                        </td>
                        <td>
                            <div class="cell-title"><?php echo e($product->title); ?></div>
                            <div class="muted"><?php echo e(\Illuminate\Support\Str::limit($product->description, 60)); ?></div>
                        </td>
                        <td><?php echo e($product->category->name); ?></td>
                        <td>
                            <?php if($product->has_discount): ?>
                                <div class="muted" style="text-decoration:line-through;"><?php echo e(number_format($product->display_original_price)); ?> d</div>
                            <?php endif; ?>
                            <strong><?php echo e(number_format($product->display_sale_price)); ?> d</strong>
                        </td>
                        <td><?php echo e($product->is_featured ? 'Co' : 'Khong'); ?></td>
                        <td>
                            <div class="inline">
                                <button class="btn secondary" type="button" onclick="document.getElementById('product-edit-modal-<?php echo e($product->id); ?>').classList.add('open')">Sua</button>
                                <form method="POST" action="<?php echo e(route('admin.products.destroy', $product)); ?>" data-confirm-message="Ban co chac chan muon xoa san pham nay khong?">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button class="btn danger">Xoa</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="muted">Chua co san pham nao.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div style="margin-top:16px;">
        <?php echo e($products->links()); ?>

    </div>

    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div id="product-edit-modal-<?php echo e($product->id); ?>" class="modal-backdrop" onclick="if(event.target===this)this.classList.remove('open')">
            <div class="modal-card">
                <div class="modal-head">
                    <h2>Cap nhat san pham</h2>
                    <button class="close-btn" type="button" onclick="document.getElementById('product-edit-modal-<?php echo e($product->id); ?>').classList.remove('open')">Dong</button>
                </div>
                <form method="POST" action="<?php echo e(route('admin.products.update', $product)); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <label class="field-label">
                        <span>Ten san pham</span>
                        <input type="text" name="title" value="<?php echo e(old('title', $product->title)); ?>" placeholder="Nhap ten san pham">
                    </label>
                    <label class="field-label">
                        <span>Mo ta</span>
                        <div class="inline" style="gap:8px;">
                            <button class="btn secondary js-format-btn" type="button" data-target="edit-product-description-<?php echo e($product->id); ?>" data-prefix="**" data-suffix="**">B</button>
                            <button class="btn secondary js-format-btn" type="button" data-target="edit-product-description-<?php echo e($product->id); ?>" data-prefix="*" data-suffix="*">I</button>
                            <button class="btn secondary js-format-btn" type="button" data-target="edit-product-description-<?php echo e($product->id); ?>" data-prefix="++" data-suffix="++">U</button>
                        </div>
                        <textarea id="edit-product-description-<?php echo e($product->id); ?>" name="description" rows="4" placeholder="Nhap mo ta"><?php echo e(old('description', $product->description)); ?></textarea>
                        <small class="muted">Ho tro: **dam**, *nghieng*, ++gach chan++, va xuong dong.</small>
                    </label>
                    <div class="inline">
                        <label class="field-label" style="flex:1 1 220px;">
                            <span>Gia goc</span>
                            <input type="number" name="original_price" value="<?php echo e(old('original_price', $product->original_price)); ?>" placeholder="Nhap gia goc">
                        </label>
                        <label class="field-label" style="flex:1 1 220px;">
                            <span>Gia ban</span>
                            <input type="number" name="price" value="<?php echo e(old('price', $product->price)); ?>" placeholder="Nhap gia ban">
                        </label>
                        <label class="field-label" style="flex:1 1 220px;">
                            <span>Danh muc</span>
                            <select name="category_id">
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($category->id); ?>" <?php if((string) old('category_id', $product->category_id) === (string) $category->id): echo 'selected'; endif; ?>><?php echo e($category->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </label>
                    </div>
                    <div class="inline" style="align-items:flex-start;">
                        <label class="field-label" style="flex:1 1 220px;">
                            <span>Anh dai dien moi</span>
                            <input type="file" name="thumbnail" accept="image/*">
                        </label>
                        <label class="field-label" style="flex:1 1 220px;">
                            <span>Anh gallery them</span>
                            <input type="file" name="gallery_images[]" accept="image/*" multiple>
                        </label>
                        <label class="field-label" style="flex:1 1 220px;">
                            <span>File source (.zip) moi</span>
                            <input type="file" name="source_zip" accept=".zip">
                        </label>
                    </div>
                    <div class="inline" style="align-items:flex-start;">
                        <div style="flex:1 1 180px;">
                            <div class="field-label">
                                <span>Anh hien tai</span>
                            </div>
                            <img class="data-thumb" src="<?php echo e(\Illuminate\Support\Str::startsWith($product->thumbnail, ['http://', 'https://']) ? $product->thumbnail : '/'.$product->thumbnail); ?>" alt="<?php echo e($product->title); ?>">
                        </div>
                        <div style="flex:2 1 320px;">
                            <div class="field-label">
                                <span>Gallery hien tai</span>
                            </div>
                            <div class="inline">
                                <?php $__empty_1 = true; $__currentLoopData = $product->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <label style="display:grid; gap:8px; padding:10px; border:1px solid rgba(148,163,184,.14); border-radius:14px; background:#0b1222;">
                                        <img class="data-thumb" src="<?php echo e(\Illuminate\Support\Str::startsWith($image->image_path, ['http://', 'https://']) ? $image->image_path : '/'.$image->image_path); ?>" alt="<?php echo e($product->title); ?>">
                                        <span style="font-size:12px; color:#94a3b8;">
                                            <input type="checkbox" name="remove_image_ids[]" value="<?php echo e($image->id); ?>" style="width:auto; margin-right:6px;">
                                            Xoa anh nay
                                        </span>
                                    </label>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <span class="muted">Chua co anh gallery.</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <label class="field-label" style="display:flex; align-items:center; gap:10px;">
                        <input type="checkbox" name="is_featured" value="1" style="width:auto;" <?php if(old('is_featured', $product->is_featured)): echo 'checked'; endif; ?>>
                        <span>Danh dau san pham noi bat</span>
                    </label>
                    <button class="btn">Luu thay doi</button>
                </form>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <?php if($errors->any()): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                document.getElementById('product-create-modal')?.classList.add('open');
            });
        </script>
    <?php endif; ?>

    <script>
        document.addEventListener('click', function (event) {
            const button = event.target.closest('.js-format-btn');

            if (!button) {
                return;
            }

            const textarea = document.getElementById(button.dataset.target);

            if (!textarea) {
                return;
            }

            const prefix = button.dataset.prefix ?? '';
            const suffix = button.dataset.suffix ?? prefix;
            const start = textarea.selectionStart ?? 0;
            const end = textarea.selectionEnd ?? 0;
            const value = textarea.value;
            const selectedText = value.slice(start, end);
            const replacement = prefix + selectedText + suffix;

            textarea.value = value.slice(0, start) + replacement + value.slice(end);
            textarea.focus();

            const cursorStart = start + prefix.length;
            const cursorEnd = cursorStart + selectedText.length;

            textarea.setSelectionRange(cursorStart, cursorEnd);
            textarea.dispatchEvent(new Event('input', { bubbles: true }));
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\lemin\laragon\www\Webbanweb\resources\views/admin/products/index.blade.php ENDPATH**/ ?>