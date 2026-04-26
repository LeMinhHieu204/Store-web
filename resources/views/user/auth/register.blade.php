@extends('layouts.user')

@section('content')
    <section class="page-section">
        <h1 class="section-title">Đăng ký tài khoản</h1>
        <div class="card" style="max-width:560px; padding:20px;">
            <form class="stack-form" method="POST" action="{{ route('user.register.submit') }}">
                @csrf
                <div style="display:grid; gap:6px;">
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Họ tên">
                    @error('name')
                        <small style="color:#be123c;">{{ $message }}</small>
                    @enderror
                </div>
                <div style="display:grid; gap:6px;">
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Email">
                    @error('email')
                        <small style="color:#be123c;">{{ $message }}</small>
                    @enderror
                </div>
                <div style="display:grid; gap:6px;">
                    <input type="password" name="password" placeholder="Mật khẩu">
                    @error('password')
                        <small style="color:#be123c;">{{ $message }}</small>
                    @enderror
                </div>
                <div style="display:grid; gap:6px;">
                    <input type="password" name="password_confirmation" placeholder="Nhập lại mật khẩu">
                </div>
                <button class="btn">Tạo tài khoản</button>
            </form>
            <p class="meta" style="margin:16px 0 0;">
                Đã có tài khoản?
                <a href="{{ route('user.login') }}" style="color:var(--blue-deep); font-weight:700;">Đăng nhập</a>
            </p>
        </div>
    </section>
@endsection
