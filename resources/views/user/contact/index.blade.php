@extends('layouts.user')

@section('content')
    @php($currentUser = auth()->user())

    <section class="page-section">
        <div class="section-head">
            <h1 class="section-title" style="margin-bottom:0;">Liên hệ</h1>
        </div>

        <div class="card" style="padding:24px;">
            <form method="POST" action="{{ route('user.contact.store') }}" class="stack-form">
                @csrf

                <div style="display:grid; grid-template-columns:repeat(2, minmax(0, 1fr)); gap:16px;">
                    <label style="display:grid; gap:8px;">
                        <span style="font-weight:700; color:#17324d;">Họ tên</span>
                        <input
                            type="text"
                            name="name"
                            value="{{ old('name', $currentUser?->name) }}"
                            placeholder="Nhập họ tên"
                        >
                    </label>

                    <label style="display:grid; gap:8px;">
                        <span style="font-weight:700; color:#17324d;">Email</span>
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email', $currentUser?->email) }}"
                            placeholder="Nhập email"
                        >
                    </label>
                </div>

                <label style="display:grid; gap:8px;">
                    <span style="font-weight:700; color:#17324d;">Nội dung cần hỗ trợ</span>
                    <textarea name="message" rows="7" placeholder="Mô tả vấn đề hoặc yêu cầu của bạn">{{ old('message') }}</textarea>
                </label>

                <div style="display:flex; justify-content:flex-start;">
                    <button class="btn" type="submit">Gửi liên hệ</button>
                </div>
            </form>
        </div>
    </section>
@endsection
