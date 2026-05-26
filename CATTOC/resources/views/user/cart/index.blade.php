@extends('user.layouts.app')
@section('title', 'Giỏ hàng - Barber House')
@section('content')
<section class="hero-gradient py-14">
    <div class="bh-container">
        <p class="bh-eyebrow">Shopping Cart</p>
        <h1 class="bh-section-title mt-3">Giỏ hàng của bạn.</h1>
        <p class="bh-muted mt-5">Kiểm tra sản phẩm chăm sóc tóc trước khi gửi đơn cho Barber House.</p>
    </div>
</section>

<section class="bh-container py-12 grid lg:grid-cols-[1fr_.42fr] gap-8" x-data="{showCheckout: {{ $items->isNotEmpty() ? 'true' : 'false' }}}">
    <div class="space-y-4">
        @forelse($items as $item)
            @php($sp = $item['san_pham'])
            <div class="bh-card p-5 flex flex-col md:flex-row gap-5 md:items-center">
                <a href="{{ route('public.san-pham.show', $sp) }}" class="h-28 w-28 rounded-[1.5rem] bg-orange-50 grid place-items-center text-4xl font-black text-orange-500 shrink-0">{{ mb_substr($sp->ten_san_pham,0,1) }}</a>
                <div class="flex-1">
                    <a href="{{ route('public.san-pham.show', $sp) }}" class="text-xl font-black hover:text-orange-500">{{ $sp->ten_san_pham }}</a>
                    <p class="text-sm text-slate-500 mt-1">{{ $sp->thuong_hieu ?? 'Barber House' }} • {{ $sp->dung_tich ?? 'Sản phẩm' }}</p>
                    <p class="font-black text-orange-500 mt-2">{{ number_format($item['gia']) }}đ</p>
                </div>
                <form method="POST" action="{{ route('public.gio-hang.update', $sp) }}" class="flex items-center gap-2">
                    @csrf @method('PATCH')
                    <input type="number" name="so_luong" min="1" max="20" value="{{ $item['so_luong'] }}" class="bh-input w-24">
                    <button class="bh-btn-light !py-2.5">Cập nhật</button>
                </form>
                <div class="font-black text-slate-950 min-w-28 text-right">{{ number_format($item['thanh_tien']) }}đ</div>
                <form method="POST" action="{{ route('public.gio-hang.remove', $sp) }}">
                    @csrf @method('DELETE')
                    <button class="rounded-2xl bg-red-50 px-4 py-3 text-sm font-black text-red-600 hover:bg-red-100">Xóa</button>
                </form>
            </div>
        @empty
            <div class="bh-card p-12 text-center">
                <h2 class="text-2xl font-black">Giỏ hàng đang trống</h2>
                <p class="text-slate-500 mt-3">Hãy chọn vài sản phẩm chăm sóc tóc phù hợp.</p>
                <a href="{{ route('public.san-pham.index') }}" class="bh-btn-primary mt-6">Mua sản phẩm</a>
            </div>
        @endforelse
    </div>

    <aside class="bh-card p-6 h-fit sticky top-28">
        <h2 class="text-2xl font-black">Tóm tắt đơn hàng</h2>
        <div class="mt-5 space-y-3 text-sm font-bold text-slate-600">
            <div class="flex justify-between"><span>Số lượng</span><span>{{ $tongSoLuong }}</span></div>
            <div class="flex justify-between"><span>Tạm tính</span><span>{{ number_format($tongTien) }}đ</span></div>
            <div class="flex justify-between"><span>Phí giao hàng</span><span>Liên hệ</span></div>
        </div>
        <div class="mt-5 border-t border-slate-200 pt-5 flex justify-between items-center">
            <span class="font-black">Tổng tiền</span>
            <span class="text-2xl font-black text-orange-500">{{ number_format($tongTien) }}đ</span>
        </div>
        @if($items->isNotEmpty())
            <button @click="showCheckout=!showCheckout" class="bh-btn-dark w-full mt-6">Thông tin nhận hàng</button>
        @endif

        <form x-show="showCheckout" x-transition method="POST" action="{{ route('public.gio-hang.checkout') }}" class="mt-6 space-y-4" style="display:none">
            @csrf
            {{-- UI NOTE: Form đặt hàng. Nếu muốn thêm tỉnh/quận/phường hãy bổ sung input ở đây và validate trong ShopController@checkout. --}}
            <div><label class="bh-label">Họ tên</label><input name="ho_ten" value="{{ old('ho_ten', auth()->user()->ho_ten ?? '') }}" class="bh-input" required></div>
            <div><label class="bh-label">Số điện thoại</label><input name="so_dien_thoai" value="{{ old('so_dien_thoai', auth()->user()->so_dien_thoai ?? '') }}" class="bh-input" required></div>
            <div><label class="bh-label">Email</label><input name="email" value="{{ old('email', auth()->user()->email ?? '') }}" class="bh-input"></div>
            <div><label class="bh-label">Địa chỉ nhận hàng</label><input name="dia_chi" value="{{ old('dia_chi', optional(auth()->user()?->khachHang)->dia_chi ?? '') }}" class="bh-input" required></div>
            <div>
                <label class="bh-label">Thanh toán</label>
                <select name="phuong_thuc_thanh_toan" class="bh-input">
                    <option value="cod">COD - Thanh toán khi nhận</option>
                    <option value="chuyen_khoan">Chuyển khoản ngân hàng</option>
                    <option value="vnpay">VNPAY Sandbox</option>
                    <option value="momo">MoMo Demo/QR</option>
                </select>
                <p class="mt-2 text-xs text-slate-500">UI NOTE: Chọn VNPAY/MoMo để chuyển sang trang hướng dẫn thanh toán sau khi đặt hàng.</p>
            </div>
            <div><label class="bh-label">Ghi chú</label><textarea name="ghi_chu" rows="3" class="bh-input">{{ old('ghi_chu') }}</textarea></div>
            <button class="bh-btn-primary w-full">Gửi đơn hàng</button>
        </form>
    </aside>
</section>
@endsection
