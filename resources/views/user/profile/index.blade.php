@extends('layouts.user')

@section('content')
    <section class="page-section" style="display:grid; grid-template-columns:minmax(320px, 420px) 1fr; gap:20px;">
        <div class="card" style="padding:20px;">
            <h1 class="section-title" style="font-size:26px;">Thong tin tai khoan</h1>
            <div style="margin-bottom:16px; padding:16px; border-radius:16px; background:linear-gradient(135deg, #eff6ff, #eef2ff); border:1px solid #dbe8f5;">
                <div class="meta">So du hien tai</div>
                <div class="price" style="font-size:28px;">{{ number_format($user->balance) }} đ</div>
            </div>
            <form class="stack-form" method="POST" action="{{ route('user.profile.update') }}">
                @csrf
                @method('PUT')
                <input type="text" name="name" value="{{ old('name', $user->name) }}" placeholder="Ho ten">
                <input type="email" name="email" value="{{ old('email', $user->email) }}" placeholder="Email">
                <input type="password" name="password" placeholder="Mat khau moi (khong bat buoc)">
                <input type="password" name="password_confirmation" placeholder="Nhap lai mat khau moi">
                <button class="btn">Cap nhat tai khoan</button>
            </form>
        </div>

        <div style="display:grid; gap:20px;">
            <div class="card" style="padding:20px;">
                <div class="section-head">
                    <h2 class="section-title" style="font-size:26px;">Nap tien tu dong</h2>
                </div>
                <div style="display:grid; grid-template-columns:minmax(260px, 340px) 1fr; gap:20px;">
                    <form class="stack-form" method="POST" action="{{ route('user.topup.store') }}">
                        @csrf
                        <input type="number" min="10000" step="1000" name="amount" placeholder="So tien muon nap">
                        <button class="btn">Tao lenh nap tien</button>
                    </form>
                    <div style="padding:16px; border:1px solid #dbe8f5; border-radius:16px; background:#f8fbff;">
                        <strong style="display:block; margin-bottom:10px;">Thong tin doi soat</strong>
                        <div class="meta" style="display:grid; gap:8px;">
                            <div>Ngan hang: <strong>{{ env('TOPUP_BANK_NAME', 'MBBank') }}</strong></div>
                            <div>Chu TK: <strong>{{ env('TOPUP_BANK_ACCOUNT_NAME', 'WEB BAN SOURCE') }}</strong></div>
                            <div>So TK: <strong>{{ env('TOPUP_BANK_ACCOUNT_NUMBER', '0123456789') }}</strong></div>
                            <div>Webhook: <strong>{{ route('user.topup.callback') }}</strong></div>
                            <div>API Key: <strong>{{ env('TOPUP_CALLBACK_API_KEY', 'chua-cau-hinh') }}</strong></div>
                            <div>Secret Key: <strong>{{ env('TOPUP_CALLBACK_SECRET', 'changeme') }}</strong></div>
                            <div>Auth API Key: <strong>Authorization: Apikey YOUR_TOKEN</strong></div>
                            <div>Auth Secret Key: <strong>X-Secret-Key: YOUR_SECRET</strong></div>
                            <div>Content-Type: <strong>application/json</strong></div>
                        </div>
                        <div class="meta" style="margin-top:12px; padding-top:12px; border-top:1px solid #dbe8f5; display:grid; gap:6px;">
                            <div>SePay URL: dung URL webhook o tren, nhung phai la domain public.</div>
                            <div>Neu dang chay Laragon voi <strong>localhost</strong>, SePay se khong goi duoc callback.</div>
                            <div>Ban can dung domain public/https hoac mo tam bang tunnel nhu ngrok/Cloudflare Tunnel.</div>
                        </div>
                        @if($latestDeposits->isNotEmpty())
                            <div style="margin-top:14px; padding-top:14px; border-top:1px solid #dbe8f5;">
                                <div class="meta" style="margin-bottom:8px;">Noi dung chuyen khoan goi y</div>
                                <strong>{{ $latestDeposits->first()->code }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div style="margin-top:16px; display:grid; gap:10px;">
                    @forelse($latestDeposits as $deposit)
                        <div style="display:flex; justify-content:space-between; gap:14px; flex-wrap:wrap; padding:14px 16px; border:1px solid #dbe8f5; border-radius:14px;">
                            <div>
                                <strong>{{ $deposit->code }}</strong>
                                <div class="meta">{{ $deposit->created_at?->format('d/m/Y H:i') }}</div>
                            </div>
                            <div style="text-align:right;">
                                <div class="price" style="font-size:20px;">{{ number_format($deposit->amount) }} đ</div>
                                <div class="meta">Trang thai: <strong>{{ strtoupper($deposit->status) }}</strong></div>
                            </div>
                        </div>
                    @empty
                        <div class="meta">Chua co giao dich nap tien nao.</div>
                    @endforelse
                </div>
            </div>

            <div class="card" style="padding:20px;">
                <div class="section-head">
                    <h2 class="section-title" style="font-size:26px;">Lich su mua hang</h2>
                </div>
                <div style="display:grid; gap:14px;">
                    @forelse($user->orders as $order)
                        <article style="border:1px solid #dbe8f5; border-radius:16px; padding:16px;">
                            <div style="display:flex; justify-content:space-between; gap:14px; flex-wrap:wrap; margin-bottom:10px;">
                                <strong>Don #{{ $order->id }}</strong>
                                <span class="price" style="font-size:20px;">{{ number_format($order->total_price) }} đ</span>
                            </div>
                            <div style="display:grid; gap:10px;">
                                @foreach($order->items as $item)
                                    <div style="display:flex; justify-content:space-between; gap:12px; flex-wrap:wrap; padding:12px; border-radius:12px; background:#f8fbff;">
                                        <div>
                                            @if($item->product)
                                                <strong>
                                                    <a href="{{ route('user.product.show', $item->product->slug) }}" style="color:inherit; text-decoration:none;">
                                                        {{ $item->product->title }}
                                                    </a>
                                                </strong>
                                            @else
                                                <strong>San pham khong con ton tai</strong>
                                            @endif
                                            <div class="meta">{{ number_format($item->price) }} đ</div>
                                        </div>
                                        <div>
                                            @if(in_array($item->product_id, $downloadableIds))
                                                <a class="btn secondary" href="{{ route('user.download', $item->product_id) }}">Tai file</a>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </article>
                    @empty
                        <div class="meta">Ban chua co don hang nao. Hay chon source code va thanh toan de bat dau.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
@endsection
