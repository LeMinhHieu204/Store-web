@extends('layouts.admin')

@section('content')
    <div class="page-head">
        <div>
            <h1>Bài viết</h1>
            <p>Quản lý nội dung hiển thị và tin tức trong hệ thống.</p>
        </div>
        <div class="inline">
            <span class="toolbar-meta">{{ $posts->count() }} bài viết</span>
            <button class="btn" type="button" onclick="document.getElementById('post-create-modal').classList.add('open')">Tạo mới</button>
        </div>
    </div>

    <div id="post-create-modal" class="modal-backdrop" onclick="if(event.target===this)this.classList.remove('open')">
        <div class="modal-card">
            <div class="modal-head">
                <h2>Tạo bài viết</h2>
                <button class="close-btn" type="button" onclick="document.getElementById('post-create-modal').classList.remove('open')">Đóng</button>
            </div>
            <form method="POST" action="{{ route('admin.posts.store') }}">
                @csrf
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
                @forelse($posts as $post)
                    <tr>
                        <td>
                            <div class="cell-title">{{ $post->title }}</div>
                            <div class="muted">{{ \Illuminate\Support\Str::limit($post->content, 80) }}</div>
                        </td>
                        <td class="muted">{{ $post->slug }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.posts.destroy', $post) }}" data-confirm-message="Bạn có chắc chắn muốn xóa bài viết này không?">
                                @csrf
                                @method('DELETE')
                                <button class="btn danger">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="muted">Chưa có bài viết nào.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
