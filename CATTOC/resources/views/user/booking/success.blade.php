@extends('user.layouts.app')
@section('title', 'Đặt lịch thành công - Barber House')
@section('content')
<section class="hero-bg py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="glass rounded-[3rem] p-8 md:p-10 text-center">
            <div class="mx-auto w-20 h-20 rounded-[2rem] bg-green-100 text-green-600 grid place-items-center text-4xl">✓</div>
            <h1 class="text-4xl font-black mt-6">Đặt lịch thành công</h1>
            <p class="text-slate-600 mt-3">Mã lịch hẹn của bạn là <strong>{{ $lichHen->ma_lich_hen }}</strong>. Vui lòng chờ admin xác nhận.</p>

            <div class="mt-8 grid md:grid-cols-2 gap-4 text-left">
                <div class="rounded-3xl bg-white border border-slate-100 p-5"><p class="text-sm text-slate-500">Khách hàng</p><strong>{{ $lichHen->khachHang->ho_ten ?? '-' }}</strong></div>
                <div class="rounded-3xl bg-white border border-slate-100 p-5"><p class="text-sm text-slate-500">Thợ</p><strong>{{ $lichHen->tho->ho_ten ?? '-' }}</strong></div>
                <div class="rounded-3xl bg-white border border-slate-100 p-5"><p class="text-sm text-slate-500">Thời gian</p><strong>{{ $lichHen->ngay_hen?->format('d/m/Y') }} • {{ $lichHen->gio_bat_dau?->format('H:i') }} - {{ $lichHen->gio_ket_thuc?->format('H:i') }}</strong></div>
                <div class="rounded-3xl bg-white border border-slate-100 p-5"><p class="text-sm text-slate-500">Tổng tiền</p><strong class="text-orange-600">{{ number_format($lichHen->tong_tien) }}đ</strong></div>
            </div>

            <div class="mt-8 rounded-3xl bg-slate-950 text-white p-5 text-left">
                <h2 class="font-black mb-3">Dịch vụ đã chọn</h2>
                <div class="space-y-2">
                    @foreach($lichHen->chiTiet as $ct)
                        <div class="flex justify-between text-sm"><span>{{ $ct->ten_dich_vu }}</span><strong>{{ number_format($ct->gia) }}đ</strong></div>
                    @endforeach
                </div>
            </div>

            <div class="mt-8 flex flex-wrap justify-center gap-3">
                @auth
                    <a href="{{ route('public.lich-cua-toi') }}" class="px-6 py-4 rounded-2xl bg-slate-950 text-white font-black hover:bg-orange-500 transition">Xem lịch của tôi</a>
                    <a href="{{ route('public.thanh-toan.index', $lichHen) }}" class="px-6 py-4 rounded-2xl bg-orange-500 text-white font-black hover:bg-slate-950 transition">Thông tin thanh toán</a>
                @else
                    <a href="{{ route('login') }}" class="px-6 py-4 rounded-2xl bg-slate-950 text-white font-black hover:bg-orange-500 transition">Đăng nhập để theo dõi</a>
                @endauth
                <a href="{{ route('public.home') }}" class="px-6 py-4 rounded-2xl bg-white border border-slate-200 font-black hover:border-orange-400 transition">Về trang chủ</a>
            </div>
        </div>
    </div>
</section>
@endsection
