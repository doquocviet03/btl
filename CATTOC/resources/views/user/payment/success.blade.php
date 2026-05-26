@extends('user.layouts.app')
@section('title', 'Đã gửi thanh toán - Barber House')
@section('content')
<section class="hero-bg py-20">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="glass rounded-[3rem] p-10 text-center">
            <div class="mx-auto w-20 h-20 rounded-[2rem] bg-orange-100 text-orange-600 grid place-items-center text-4xl">✓</div>
            <h1 class="text-4xl font-black mt-6">Đã gửi thông tin thanh toán</h1>
            <p class="text-slate-600 mt-3">Admin sẽ kiểm tra và xác nhận thanh toán cho lịch <strong>{{ $lichHen->ma_lich_hen }}</strong>.</p>
            <div class="mt-8 flex justify-center gap-3 flex-wrap">
                <a href="{{ route('public.lich-cua-toi') }}" class="px-6 py-4 rounded-2xl bg-slate-950 text-white font-black hover:bg-orange-500 transition">Về lịch của tôi</a>
                <a href="{{ route('public.home') }}" class="px-6 py-4 rounded-2xl bg-white border border-slate-200 font-black">Trang chủ</a>
            </div>
        </div>
    </div>
</section>
@endsection
