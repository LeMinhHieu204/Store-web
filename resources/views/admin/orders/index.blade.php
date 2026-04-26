@extends('layouts.admin')

@section('content')
    <div class="page-head">
        <div>
            <h1>Đơn hàng</h1>
            <p>Theo dõi nhanh khách hàng, sản phẩm và tổng tiền từng đơn.</p>
        </div>
        <div class="inline">
            <span class="toolbar-meta">{{ $orders->count() }} đơn hiển thị</span>
        </div>
    </div>

    <div class="table-wrap">
        <div class="table-head">
            <h3>Danh sách đơn hàng</h3>
            <span class="table-chip">Cập nhật gần đây</span>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Đơn</th>
                    <th>Khách hàng</th>
                    <th>Sản phẩm</th>
                    <th>Tổng tiền</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>
                            <div class="cell-title">#{{ $order->id }}</div>
                        </td>
                        <td>{{ $order->user->name }}</td>
                        <td>
                            <div class="muted">
                                {{ $order->items->count() }} sản phẩm
                                @if($order->items->isNotEmpty())
                                    - {{ $order->items->first()->product->title }}
                                    @if($order->items->count() > 1)
                                        và {{ $order->items->count() - 1 }} mục khác
                                    @endif
                                @endif
                            </div>
                        </td>
                        <td>
                            <strong>{{ number_format($order->total_price) }} đ</strong>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="muted">Chưa có đơn hàng nào.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
