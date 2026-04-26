@extends('layouts.admin')

@section('content')
    <div class="page-head">
        <div>
            <h1>Danh mục</h1>
            <p>Quản lý nhóm sản phẩm và ảnh đại diện cho từng danh mục.</p>
        </div>
        <div class="inline">
            <span class="toolbar-meta">{{ $categories->count() }} danh mục</span>
            <button class="btn" type="button" onclick="document.getElementById('category-create-modal').classList.add('open')">Tạo mới</button>
        </div>
    </div>

    <div id="category-create-modal" class="modal-backdrop" onclick="if(event.target===this)this.classList.remove('open')">
        <div class="modal-card">
            <div class="modal-head">
                <h2>Tạo danh mục</h2>
                <button class="close-btn" type="button" onclick="document.getElementById('category-create-modal').classList.remove('open')">Đóng</button>
            </div>
            <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data">
                @csrf
                <label class="field-label">
                    <span>Tên danh mục</span>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Tên danh mục">
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
                @forelse($categories as $category)
                    <tr>
                        <td>
                            @if($category->image_path)
                                <img class="data-thumb" src="{{ \Illuminate\Support\Str::startsWith($category->image_path, ['http://', 'https://']) ? $category->image_path : '/'.$category->image_path }}" alt="{{ $category->name }}">
                            @endif
                        </td>
                        <td>
                            <div class="cell-title">{{ $category->name }}</div>
                        </td>
                        <td class="muted">{{ $category->slug }}</td>
                        <td>{{ $category->products_count }}</td>
                        <td>
                            <div class="inline">
                                <button class="btn secondary" type="button" onclick="document.getElementById('category-edit-modal-{{ $category->id }}').classList.add('open')">Sửa</button>
                                <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" data-confirm-message="Bạn có chắc chắn muốn xóa danh mục này không?">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn danger">Xóa</button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    <div id="category-edit-modal-{{ $category->id }}" class="modal-backdrop" onclick="if(event.target===this)this.classList.remove('open')">
                        <div class="modal-card">
                            <div class="modal-head">
                                <h2>Cập nhật danh mục</h2>
                                <button class="close-btn" type="button" onclick="document.getElementById('category-edit-modal-{{ $category->id }}').classList.remove('open')">Đóng</button>
                            </div>
                            <form method="POST" action="{{ route('admin.categories.update', $category) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <label class="field-label">
                                    <span>Tên danh mục</span>
                                    <input type="text" name="name" value="{{ $category->name }}" placeholder="Tên danh mục">
                                </label>
                                <label class="field-label">
                                    <span>Slug hiện tại</span>
                                    <input type="text" value="{{ $category->slug }}" disabled>
                                </label>
                                @if($category->image_path)
                                    <div class="field-label">
                                        <span>Ảnh hiện tại</span>
                                        <img class="data-thumb" src="{{ \Illuminate\Support\Str::startsWith($category->image_path, ['http://', 'https://']) ? $category->image_path : '/'.$category->image_path }}" alt="{{ $category->name }}">
                                    </div>
                                @endif
                                <label class="field-label">
                                    <span>Ảnh đại diện mới</span>
                                    <input type="file" name="image" accept="image/*">
                                </label>
                                <button class="btn">Lưu thay đổi</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <tr>
                        <td colspan="5" class="muted">Chưa có danh mục nào.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
