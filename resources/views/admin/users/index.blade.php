@extends('layouts.admin')

@section('content')
    <div class="page-head">
        <div>
            <h1>Người dùng</h1>
            <p>Theo dõi tài khoản, email và vai trò trong hệ thống.</p>
        </div>
        <div class="inline">
            <span class="toolbar-meta">{{ $users->count() }} tài khoản</span>
        </div>
    </div>

    <div class="table-wrap">
        <div class="table-head">
            <h3>Danh sách người dùng</h3>
            <span class="table-chip">Accounts</span>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Tên</th>
                    <th>Email</th>
                    <th>Vai trò</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>
                            <div class="cell-title">{{ $user->name }}</div>
                        </td>
                        <td class="muted">{{ $user->email }}</td>
                        <td>
                            @if($user->role === 'admin')
                                <span class="status-badge green">Quản trị</span>
                            @else
                                <span class="status-badge amber">Người dùng</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="muted">Chưa có tài khoản nào.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
