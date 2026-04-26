@extends('layouts.admin')

@section('content')
    <div class="page-head">
        <div>
            <h1>Liên hệ</h1>
            <p>Tổng hợp các tin nhắn gửi từ người dùng để xử lý nhanh.</p>
        </div>
        <div class="inline">
            <span class="toolbar-meta">{{ $contacts->count() }} liên hệ</span>
        </div>
    </div>

    <div class="table-wrap">
        <div class="table-head">
            <h3>Hộp thư đến</h3>
            <span class="table-chip">Inbox</span>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Họ tên</th>
                    <th>Email</th>
                    <th>Nội dung</th>
                </tr>
            </thead>
            <tbody>
                @forelse($contacts as $contact)
                    <tr>
                        <td>
                            <div class="cell-title">{{ $contact->name }}</div>
                        </td>
                        <td class="muted">{{ $contact->email }}</td>
                        <td>{{ $contact->message }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="muted">Chưa có liên hệ nào.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
