@extends('user.layouts.app')
@section('title', $dichVu->ten_dich_vu . ' - Barber House')
@section('meta_description', $dichVu->mo_ta ?? 'Chi tiết dịch vụ cắt tóc nam tại Barber House, xem giá, thời gian và đặt lịch nhanh.')
@section('content')
<section class="bh-page-hero">
    <div class="bh-container grid items-center gap-10 lg:grid-cols-[1fr_.85fr]">
        <div>
            <a href="{{ route('public.dich-vu.index') }}" class="text-sm font-black text-zinc-400 hover:text-white">← Quay lại dịch vụ</a>
            <p class="bh-eyebrow mt-7">{{ $dichVu->danhMuc->ten_danh_muc ?? 'Service Detail' }}</p>
            <h1 class="bh-section-title mt-4 max-w-4xl">{{ $dichVu->ten_dich_vu }}</h1>
            <p class="mt-6 max-w-2xl text-lg leading-relaxed text-zinc-300">{{ $dichVu->mo_ta ?? 'Dịch vụ chuyên nghiệp, phù hợp nhiều phong cách tóc nam hiện đại.' }}</p>
            <div class="mt-8 grid max-w-xl grid-cols-2 gap-4">
                <div class="bh-mini-card"><p class="text-sm text-zinc-500">Giá dịch vụ</p><strong class="bh-price">{{ number_format($dichVu->gia) }}đ</strong></div>
                <div class="bh-mini-card"><p class="text-sm text-zinc-500">Thời gian</p><strong class="text-2xl font-black text-white">{{ $dichVu->thoi_gian }} phút</strong></div>
            </div>
            <a href="{{ route('public.dat-lich.index', ['dich_vu_ids[]' => $dichVu->id]) }}" class="bh-btn-primary mt-8">Đặt dịch vụ này</a>
        </div>
        <div class="bh-dark-card relative min-h-[28rem] overflow-hidden p-8">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_55%_22%,rgba(255,53,53,.6),transparent_24%),radial-gradient(circle_at_42%_50%,rgba(183,43,255,.55),transparent_45%)]"></div>
            <div class="relative z-10 flex h-full flex-col justify-between">
                <div class="flex justify-between"><span class="bh-chip">Barber House</span><span class="bh-chip">{{ $dichVu->thoi_gian }} min</span></div>
                <div>
                    <p class="text-8xl font-black tracking-[-.1em] text-white/80">CUT</p>
                    <p class="mt-4 max-w-sm text-zinc-300">Tư vấn kiểu tóc, thực hiện gọn, sạch, đúng giờ và có thể thanh toán online.</p>
                </div>
            </div>
        </div>
    </div>
</section>

@if($lienQuan->count())
<section class="bh-container py-14">
    <div class="mb-6 flex items-end justify-between gap-4">
        <div>
            <p class="bh-eyebrow">Related</p>
            <h2 class="mt-3 text-4xl font-black tracking-[-.06em] text-white md:text-6xl">Dịch vụ liên quan</h2>
        </div>
    </div>
    <div class="grid gap-5 md:grid-cols-3">
        @foreach($lienQuan as $dv)
            <a href="{{ route('public.dich-vu.show', $dv) }}" class="bh-card p-6 transition hover:-translate-y-2">
                <h3 class="text-2xl font-black tracking-[-.04em] text-white">{{ $dv->ten_dich_vu }}</h3>
                <p class="mt-2 text-zinc-500">{{ $dv->thoi_gian }} phút</p>
                <strong class="mt-6 block text-2xl font-black text-orange-400">{{ number_format($dv->gia) }}đ</strong>
            </a>
        @endforeach
    </div>
</section>
@endif
@endsection
