@extends('user.layouts.app')
@section('title', 'Đặt hàng thành công - Barber House')
@section('content')
@php
    // UI NOTE: Trang thành công đơn hàng hiển thị phương thức COD, MoMo Demo/Sandbox và VNPAY Sandbox.
    $momoQrImage = config('momo.static_qr_image');
    $momoReceiver = config('momo.receiver_name');
    $momoPhone = config('momo.receiver_phone');
    $momoConfigured = app(\App\Services\MomoPaymentService::class)->isConfigured();
    $vnpayConfigured = app(\App\Services\VnpayPaymentService::class)->isConfigured();
    $methodLabels = [
        'cod' => 'COD',
        'chuyen_khoan' => 'Chuyển khoản',
        'momo' => 'MoMo Demo/QR',
        'vnpay' => 'VNPAY Sandbox',
    ];
@endphp
<section class="hero-gradient py-16">
    <div class="bh-container text-center max-w-4xl">
        <div class="mx-auto h-20 w-20 rounded-[2rem] bg-orange-500 text-white grid place-items-center text-3xl font-black">✓</div>
        <p class="bh-eyebrow mt-6">Order Success</p>
        <h1 class="bh-section-title mt-3">Đặt hàng thành công.</h1>
        <p class="bh-muted mt-5">Mã đơn hàng của bạn là <strong class="text-slate-950">{{ $donHang->ma_don_hang }}</strong>. Barber House sẽ liên hệ xác nhận sớm.</p>

        <div class="mt-8 bh-card p-6 text-left">
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4 text-sm font-bold">
                <div><span class="text-slate-400">Khách hàng</span><div>{{ $donHang->ho_ten }}</div></div>
                <div><span class="text-slate-400">Số điện thoại</span><div>{{ $donHang->so_dien_thoai }}</div></div>
                <div><span class="text-slate-400">Tổng tiền</span><div class="text-orange-500 text-xl font-black">{{ number_format($donHang->tong_tien) }}đ</div></div>
                <div><span class="text-slate-400">Trạng thái đơn</span><div><x-badge-status :status="$donHang->trang_thai" /></div></div>
                <div><span class="text-slate-400">Phương thức</span><div>{{ $methodLabels[$donHang->phuong_thuc_thanh_toan] ?? $donHang->phuong_thuc_thanh_toan }}</div></div>
                <div><span class="text-slate-400">Thanh toán</span><div><x-badge-status :status="$donHang->trang_thai_thanh_toan ?? 'chua_thanh_toan'" /></div></div>
            </div>
        </div>

        @if($donHang->phuong_thuc_thanh_toan === 'vnpay')
            <div class="mt-8 bh-card p-6 text-left">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">
                    <div>
                        <p class="bh-eyebrow">VNPAY Sandbox</p>
                        <h2 class="mt-2 text-2xl font-black">Thanh toán đơn hàng qua VNPAY</h2>
                        <p class="mt-2 text-sm text-slate-500">Tạo link sandbox để mô phỏng cổng thanh toán VNPAY. Sau callback hợp lệ, trạng thái đơn hàng sẽ được cập nhật.</p>
                    </div>
                    <div class="rounded-2xl {{ $vnpayConfigured ? 'bg-emerald-50 text-emerald-700 border-emerald-100' : 'bg-amber-50 text-amber-700 border-amber-100' }} border px-5 py-3 text-sm font-black">
                        {{ $vnpayConfigured ? 'Đã cấu hình sandbox' : 'Chưa cấu hình sandbox' }}
                    </div>
                </div>
                @if($donHang->vnpay_payment_url)
                    <a href="{{ $donHang->vnpay_payment_url }}" target="_blank" class="mt-5 bh-btn-light w-full">Mở lại link VNPAY</a>
                @endif
                <form method="POST" action="{{ route('vnpay.order.create', $donHang) }}" class="mt-5 grid md:grid-cols-[1fr_auto] gap-3">
                    @csrf
                    <select name="bank_code" class="bh-input">
                        <option value="">Để VNPAY tự chọn phương thức</option>
                        <option value="VNPAYQR">VNPAY QR</option>
                        <option value="NCB">Thẻ test NCB</option>
                        <option value="ATM">ATM nội địa</option>
                        <option value="INTCARD">Thẻ quốc tế</option>
                    </select>
                    <button class="bh-btn-dark">Tạo link VNPAY</button>
                </form>
            </div>
        @endif

        @if($donHang->phuong_thuc_thanh_toan === 'momo')
            <div class="mt-8 grid lg:grid-cols-2 gap-5 text-left">
                <div class="bh-card p-6 border-fuchsia-100 bg-fuchsia-50">
                    <div class="flex items-center gap-3">
                        <div class="h-12 w-12 rounded-2xl bg-[#a50064] text-white grid place-items-center font-black">M</div>
                        <div>
                            <h2 class="text-xl font-black">Thanh toán MoMo Demo/QR</h2>
                            <p class="text-sm text-slate-500">Quét QR và nhập đúng nội dung để admin đối soát.</p>
                        </div>
                    </div>
                    <div class="mt-4 bg-white rounded-[1.5rem] p-4 border border-fuchsia-100">
                        <img src="{{ $momoQrImage }}" alt="MoMo QR" class="mx-auto w-56 h-56 object-contain rounded-2xl">
                    </div>
                    <div class="mt-4 space-y-2 text-sm font-bold text-slate-700">
                        <div class="flex justify-between gap-3"><span class="text-slate-400">Người nhận</span><span class="text-right">{{ $momoReceiver }}</span></div>
                        <div class="flex justify-between gap-3"><span class="text-slate-400">Số MoMo</span><span>{{ $momoPhone }}</span></div>
                        <div class="flex justify-between gap-3"><span class="text-slate-400">Số tiền</span><span class="text-orange-600">{{ number_format($donHang->tong_tien) }}đ</span></div>
                        <div class="flex justify-between gap-3"><span class="text-slate-400">Nội dung</span><span class="font-black">{{ $donHang->ma_don_hang }}</span></div>
                    </div>
                </div>

                <div class="bh-card p-6">
                    <h2 class="text-xl font-black">MoMo Sandbox Gateway</h2>
                    <p class="text-sm text-slate-500 mt-2">Nếu đã cấu hình Merchant/Sandbox, nút dưới sẽ chuyển sang trang thanh toán MoMo.</p>
                    <div class="mt-4 rounded-2xl bg-slate-50 p-4 text-sm font-bold">
                        <div class="flex justify-between"><span>Trạng thái cấu hình</span><span class="{{ $momoConfigured ? 'text-emerald-600' : 'text-amber-600' }}">{{ $momoConfigured ? 'Đã cấu hình' : 'Chưa cấu hình' }}</span></div>
                        @if($donHang->momo_pay_url)
                            <a href="{{ $donHang->momo_pay_url }}" target="_blank" class="mt-4 bh-btn-light w-full text-center">Mở lại link MoMo</a>
                        @endif
                    </div>
                    <form method="POST" action="{{ route('momo.order.create', $donHang) }}" class="mt-4">
                        @csrf
                        <button class="w-full rounded-2xl bg-[#a50064] px-5 py-4 text-white font-black hover:bg-slate-950 transition">
                            {{ $momoConfigured ? 'Thanh toán qua MoMo Sandbox' : 'Chọn MoMo QR Demo' }}
                        </button>
                    </form>
                    <p class="text-xs text-slate-400 mt-3">Khi chưa có Merchant API, dùng QR tĩnh và admin xác nhận trong trang đơn hàng.</p>
                </div>
            </div>
        @endif

        <div class="mt-8 flex flex-wrap justify-center gap-3">
            <a href="{{ route('public.san-pham.index') }}" class="bh-btn-light">Tiếp tục mua</a>
            <a href="{{ route('public.home') }}" class="bh-btn-dark">Về trang chủ</a>
        </div>
    </div>
</section>
@endsection
