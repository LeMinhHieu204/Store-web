@extends('layouts.user')

@section('content')
    <section class="page-section">
        <h1 class="section-title">Đăng nhập</h1>
        <div class="card" style="max-width:560px; padding:20px;">
            <form class="stack-form" method="POST" action="{{ route('user.login.submit') }}">
                @csrf
                <div style="display:grid; gap:6px;">
                    <input type="text" name="login" value="{{ old('login') }}" placeholder="Tên đăng nhập hoặc email">
                    @error('login')
                        <small style="color:#be123c;">{{ $message }}</small>
                    @enderror
                </div>
                <div style="display:grid; gap:6px;">
                    <input type="password" name="password" placeholder="Mật khẩu">
                    @error('password')
                        <small style="color:#be123c;">{{ $message }}</small>
                    @enderror
                </div>
                <button class="btn">Đăng nhập</button>
            </form>
            <p class="meta" style="margin:16px 0 0;">
                Chưa có tài khoản?
                <a href="{{ route('user.register') }}" style="color:var(--blue-deep); font-weight:700;">Đăng ký ngay</a>
            </p>
        </div>
    </section>
@endsection
