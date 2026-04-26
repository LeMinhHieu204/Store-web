@extends('layouts.user')

@section('content')
    <section class="page-section card" style="padding:20px;">
        <div class="section-head">
            <h1 class="section-title">Gio hang</h1>
            <a class="section-link" href="{{ route('user.products') }}">Tiep tuc mua sam</a>
        </div>

        @if($cartItems->isEmpty())
            <p class="meta">Gio hang hien dang trong. Hay them san pham truoc khi thanh toan.</p>
        @else
            <div style="display:grid; gap:14px;">
                @foreach($cartItems as $item)
                    <article style="display:grid; grid-template-columns:120px 1fr auto; gap:16px; align-items:center; padding:16px; border:1px solid #dbe8f5; border-radius:16px;">
                        <img src="{{ \Illuminate\Support\Str::startsWith($item['product']->thumbnail, ['http://', 'https://']) ? $item['product']->thumbnail : '/'.$item['product']->thumbnail }}" alt="{{ $item['product']->title }}" style="width:120px; height:90px; object-fit:cover; border-radius:12px;">
                        <div>
                            <h3 style="margin:0 0 8px;">{{ $item['product']->title }}</h3>
                            <div class="meta">{{ $item['product']->category->name }}</div>
                            <div style="margin-top:8px;">
                                @if($item['product']->has_discount)
                                    <div class="meta" style="text-decoration:line-through;">{{ number_format($item['product']->display_original_price) }} đ</div>
                                @endif
                                <div class="price" style="font-size:20px;">{{ number_format($item['product']->display_sale_price) }} đ</div>
                            </div>
                        </div>
                        <div style="display:grid; gap:10px; justify-items:end;">
                            <form method="POST" action="{{ route('user.cart.update', $item['product']) }}" style="display:flex; gap:8px; align-items:center;">
                                @csrf
                                @method('PATCH')
                                <input type="number" min="1" max="10" name="quantity" value="{{ $item['quantity'] }}" style="width:80px; padding:10px 12px;">
                                <button class="btn secondary">Cap nhat</button>
                            </form>
                            <form method="POST" action="{{ route('user.cart.remove', $item['product']) }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn">Xoa</button>
                            </form>
                        </div>
                    </article>
                @endforeach
            </div>

            <div style="display:flex; justify-content:space-between; gap:16px; align-items:center; flex-wrap:wrap; margin-top:20px; padding-top:18px; border-top:1px solid #dbe8f5;">
                <div>
                    <div class="meta">Tong thanh toan</div>
                    <div class="price" style="font-size:28px;">{{ number_format($cartTotal) }} đ</div>
                    @auth
                        <div class="meta" style="margin-top:6px;">So du vi: {{ number_format($walletBalance) }} đ</div>
                    @endauth
                </div>
                @auth
                    <div style="display:grid; gap:10px; justify-items:end;">
                        <form method="POST" action="{{ route('user.checkout') }}">
                            @csrf
                            <button class="btn" {{ $walletBalance < $cartTotal ? 'disabled' : '' }}>Thanh toan bang so du</button>
                        </form>
                        @if($walletBalance < $cartTotal)
                            <div class="meta">So du khong du. Vao Tai khoan cua toi de nap them.</div>
                        @endif
                    </div>
                @else
                    <a class="btn" href="{{ route('user.login') }}">Dang nhap de thanh toan</a>
                @endauth
            </div>
        @endif
    </section>
@endsection
