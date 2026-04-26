@extends('layouts.admin')

@section('content')
    @if($errors->any())
        <div class="card" style="margin-bottom:18px; color:#fca5a5;">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="page-head">
        <div>
            <h1>San pham</h1>
            <p>Quan ly source code, gia ban va hinh anh hien thi.</p>
        </div>
        <div class="inline">
            <span class="toolbar-meta">{{ $products->total() }} san pham</span>
            <button class="btn" type="button" onclick="document.getElementById('product-create-modal').classList.add('open')">Tao moi</button>
        </div>
    </div>

    <div id="product-create-modal" class="modal-backdrop" onclick="if(event.target===this)this.classList.remove('open')">
        <div class="modal-card">
            <div class="modal-head">
                <h2>Tao san pham</h2>
                <button class="close-btn" type="button" onclick="document.getElementById('product-create-modal').classList.remove('open')">Dong</button>
            </div>
            <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
                @csrf
                <label class="field-label">
                    <span>Ten san pham</span>
                    <input type="text" name="title" value="{{ old('title') }}" placeholder="Nhap ten san pham">
                </label>
                <label class="field-label">
                    <span>Mo ta</span>
                    <div class="inline" style="gap:8px;">
                        <button class="btn secondary js-format-btn" type="button" data-target="create-product-description" data-prefix="**" data-suffix="**">B</button>
                        <button class="btn secondary js-format-btn" type="button" data-target="create-product-description" data-prefix="*" data-suffix="*">I</button>
                        <button class="btn secondary js-format-btn" type="button" data-target="create-product-description" data-prefix="++" data-suffix="++">U</button>
                    </div>
                    <textarea id="create-product-description" name="description" rows="4" placeholder="Nhap mo ta">{{ old('description') }}</textarea>
                    <small class="muted">Ho tro: **dam**, *nghieng*, ++gach chan++, va xuong dong.</small>
                </label>
                <div class="inline">
                    <label class="field-label" style="flex:1 1 220px;">
                        <span>Gia goc</span>
                        <input type="number" name="original_price" value="{{ old('original_price') }}" placeholder="Nhap gia goc">
                    </label>
                    <label class="field-label" style="flex:1 1 220px;">
                        <span>Gia ban</span>
                        <input type="number" name="price" value="{{ old('price') }}" placeholder="Nhap gia ban">
                    </label>
                    <label class="field-label" style="flex:1 1 220px;">
                        <span>Danh muc</span>
                        <select name="category_id">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" @selected((string) old('category_id') === (string) $category->id)>{{ $category->name }}</option>
                            @endforeach
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
                    <input type="checkbox" name="is_featured" value="1" style="width:auto;" @checked(old('is_featured'))>
                    <span>Danh dau san pham noi bat</span>
                </label>
                <button class="btn">Them san pham</button>
            </form>
        </div>
    </div>

    <div class="table-wrap">
        <div class="table-head">
            <h3>Danh sach san pham</h3>
            <span class="table-chip">Trang {{ $products->currentPage() }} / {{ $products->lastPage() }}</span>
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
                @forelse($products as $product)
                    <tr>
                        <td>
                            <img class="data-thumb" src="{{ \Illuminate\Support\Str::startsWith($product->thumbnail, ['http://', 'https://']) ? $product->thumbnail : '/'.$product->thumbnail }}" alt="{{ $product->title }}">
                        </td>
                        <td>
                            <div class="cell-title">{{ $product->title }}</div>
                            <div class="muted">{{ \Illuminate\Support\Str::limit($product->description, 60) }}</div>
                        </td>
                        <td>{{ $product->category->name }}</td>
                        <td>
                            @if($product->has_discount)
                                <div class="muted" style="text-decoration:line-through;">{{ number_format($product->display_original_price) }} d</div>
                            @endif
                            <strong>{{ number_format($product->display_sale_price) }} d</strong>
                        </td>
                        <td>{{ $product->is_featured ? 'Co' : 'Khong' }}</td>
                        <td>
                            <div class="inline">
                                <button class="btn secondary" type="button" onclick="document.getElementById('product-edit-modal-{{ $product->id }}').classList.add('open')">Sua</button>
                                <form method="POST" action="{{ route('admin.products.destroy', $product) }}" data-confirm-message="Ban co chac chan muon xoa san pham nay khong?">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn danger">Xoa</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="muted">Chua co san pham nao.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:16px;">
        {{ $products->links() }}
    </div>

    @foreach($products as $product)
        <div id="product-edit-modal-{{ $product->id }}" class="modal-backdrop" onclick="if(event.target===this)this.classList.remove('open')">
            <div class="modal-card">
                <div class="modal-head">
                    <h2>Cap nhat san pham</h2>
                    <button class="close-btn" type="button" onclick="document.getElementById('product-edit-modal-{{ $product->id }}').classList.remove('open')">Dong</button>
                </div>
                <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <label class="field-label">
                        <span>Ten san pham</span>
                        <input type="text" name="title" value="{{ old('title', $product->title) }}" placeholder="Nhap ten san pham">
                    </label>
                    <label class="field-label">
                        <span>Mo ta</span>
                        <div class="inline" style="gap:8px;">
                            <button class="btn secondary js-format-btn" type="button" data-target="edit-product-description-{{ $product->id }}" data-prefix="**" data-suffix="**">B</button>
                            <button class="btn secondary js-format-btn" type="button" data-target="edit-product-description-{{ $product->id }}" data-prefix="*" data-suffix="*">I</button>
                            <button class="btn secondary js-format-btn" type="button" data-target="edit-product-description-{{ $product->id }}" data-prefix="++" data-suffix="++">U</button>
                        </div>
                        <textarea id="edit-product-description-{{ $product->id }}" name="description" rows="4" placeholder="Nhap mo ta">{{ old('description', $product->description) }}</textarea>
                        <small class="muted">Ho tro: **dam**, *nghieng*, ++gach chan++, va xuong dong.</small>
                    </label>
                    <div class="inline">
                        <label class="field-label" style="flex:1 1 220px;">
                            <span>Gia goc</span>
                            <input type="number" name="original_price" value="{{ old('original_price', $product->original_price) }}" placeholder="Nhap gia goc">
                        </label>
                        <label class="field-label" style="flex:1 1 220px;">
                            <span>Gia ban</span>
                            <input type="number" name="price" value="{{ old('price', $product->price) }}" placeholder="Nhap gia ban">
                        </label>
                        <label class="field-label" style="flex:1 1 220px;">
                            <span>Danh muc</span>
                            <select name="category_id">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" @selected((string) old('category_id', $product->category_id) === (string) $category->id)>{{ $category->name }}</option>
                                @endforeach
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
                            <img class="data-thumb" src="{{ \Illuminate\Support\Str::startsWith($product->thumbnail, ['http://', 'https://']) ? $product->thumbnail : '/'.$product->thumbnail }}" alt="{{ $product->title }}">
                        </div>
                        <div style="flex:2 1 320px;">
                            <div class="field-label">
                                <span>Gallery hien tai</span>
                            </div>
                            <div class="inline">
                                @forelse($product->images as $image)
                                    <label style="display:grid; gap:8px; padding:10px; border:1px solid rgba(148,163,184,.14); border-radius:14px; background:#0b1222;">
                                        <img class="data-thumb" src="{{ \Illuminate\Support\Str::startsWith($image->image_path, ['http://', 'https://']) ? $image->image_path : '/'.$image->image_path }}" alt="{{ $product->title }}">
                                        <span style="font-size:12px; color:#94a3b8;">
                                            <input type="checkbox" name="remove_image_ids[]" value="{{ $image->id }}" style="width:auto; margin-right:6px;">
                                            Xoa anh nay
                                        </span>
                                    </label>
                                @empty
                                    <span class="muted">Chua co anh gallery.</span>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    <label class="field-label" style="display:flex; align-items:center; gap:10px;">
                        <input type="checkbox" name="is_featured" value="1" style="width:auto;" @checked(old('is_featured', $product->is_featured))>
                        <span>Danh dau san pham noi bat</span>
                    </label>
                    <button class="btn">Luu thay doi</button>
                </form>
            </div>
        </div>
    @endforeach

    @if($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                document.getElementById('product-create-modal')?.classList.add('open');
            });
        </script>
    @endif

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
@endsection
