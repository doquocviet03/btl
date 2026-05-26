@extends('user.layouts.app')
@section('title', $sanPham->ten_san_pham . ' - Barber House')
@section('content')
<section class="hero-gradient py-14">
    <div class="bh-container grid lg:grid-cols-2 gap-10 items-center">
        <div class="bh-card-soft h-[420px] grid place-items-center text-8xl font-black text-orange-500">{{ mb_substr($sanPham->ten_san_pham,0,1) }}</div>
        <div>
            <p class="bh-eyebrow">{{ $sanPham->thuong_hieu ?? 'Barber House' }}</p>
            <h1 class="bh-title mt-3">{{ $sanPham->ten_san_pham }}</h1>
            <p class="bh-muted mt-5">{{ $sanPham->mo_ta_ngan }}</p>
            <div class="mt-6 flex items-end gap-4">
                <div class="text-4xl font-black text-orange-500">{{ number_format($sanPham->gia_ban) }}đ</div>
                @if($sanPham->gia_khuyen_mai)
                    <div class="text-lg text-slate-400 line-through mb-1">{{ number_format($sanPham->gia) }}đ</div>
                @endif
            </div>
            <div class="mt-8 bh-card p-5">
                <form method="POST" action="{{ route('public.gio-hang.add', $sanPham) }}" class="flex flex-col sm:flex-row gap-3">
                    @csrf
                    <input type="number" min="1" max="20" name="so_luong" value="1" class="bh-input sm:w-32">
                    <button class="bh-btn-primary flex-1">Thêm vào giỏ hàng</button>
                </form>
            </div>
        </div>
    </div>
</section>
<section class="bh-container py-12 grid lg:grid-cols-[1fr_.45fr] gap-8">
    <div class="bh-card p-8">
        <h2 class="text-2xl font-black">Thông tin sản phẩm</h2>
        <div class="prose max-w-none mt-5 text-slate-600 whitespace-pre-line">{{ $sanPham->mo_ta_chi_tiet ?: $sanPham->mo_ta_ngan }}</div>
    </div>
    <aside class="space-y-4">
        <div class="bh-card p-6"><div class="text-sm font-black text-slate-400">Loại sản phẩm</div><div class="mt-2 font-black">{{ ['cham_soc_toc'=>'Chăm sóc tóc','cham_soc_da_dau'=>'Chăm sóc da đầu','tao_kieu'=>'Tạo kiểu','combo'=>'Combo'][$sanPham->loai_san_pham] ?? $sanPham->loai_san_pham }}</div></div>
        <div class="bh-card p-6"><div class="text-sm font-black text-slate-400">Tồn kho</div><div class="mt-2 font-black">{{ $sanPham->so_luong_ton }} sản phẩm</div></div>
        <div class="bh-card p-6"><div class="text-sm font-black text-slate-400">Dung tích</div><div class="mt-2 font-black">{{ $sanPham->dung_tich ?? 'Đang cập nhật' }}</div></div>
    </aside>
</section>
@if($lienQuan->count())
<section class="bh-container pb-12">
    <h2 class="text-3xl font-black tracking-tight mb-6">Sản phẩm liên quan</h2>
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($lienQuan as $sp)
            <a href="{{ route('public.san-pham.show', $sp) }}" class="bh-card p-5 hover:-translate-y-1 transition">
                <div class="h-32 rounded-[1.5rem] bg-orange-50 grid place-items-center text-4xl font-black text-orange-500">{{ mb_substr($sp->ten_san_pham,0,1) }}</div>
                <h3 class="font-black mt-4">{{ $sp->ten_san_pham }}</h3>
                <p class="text-orange-500 font-black mt-2">{{ number_format($sp->gia_ban) }}đ</p>
            </a>
        @endforeach
    </div>
</section>
@endif
@endsection
