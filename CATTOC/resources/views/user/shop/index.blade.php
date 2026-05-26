@extends('user.layouts.app')
@section('title', 'Sản phẩm chăm sóc tóc nam - Barber House')
@section('meta_description', 'Mua sản phẩm chăm sóc tóc nam, sáp vuốt tóc, dầu gội, combo tạo kiểu và chăm sóc da đầu tại Barber House.')
@section('content')
<section class="bh-page-hero">
    <div class="bh-container grid items-center gap-10 lg:grid-cols-[1.15fr_.85fr]">
        <div>
            <p class="bh-eyebrow">Hair Care Shop</p>
            <h1 class="bh-section-title mt-4 max-w-5xl">Sản phẩm giữ form tóc sau salon.</h1>
            <p class="mt-5 max-w-2xl text-zinc-400">Sáp vuốt tóc, dầu gội, tinh dầu dưỡng và combo chăm sóc tóc được chọn lọc cho chất tóc nam Việt Nam.</p>
            <div class="mt-8 flex flex-wrap gap-3">
                <a href="{{ route('public.gio-hang.index') }}" class="bh-btn-primary">Xem giỏ hàng</a>
                <a href="{{ route('public.dat-lich.index') }}" class="bh-btn-light">Đặt lịch tư vấn</a>
            </div>
        </div>
        <div class="bh-dark-card p-8">
            <p class="text-sm font-bold text-zinc-400">Barber House Care</p>
            <div class="mt-6 grid grid-cols-2 gap-4">
                <div class="rounded-3xl bg-white/10 p-5"><div class="text-3xl font-black text-orange-400">100%</div><p class="mt-2 text-sm text-zinc-400">sản phẩm chọn lọc</p></div>
                <div class="rounded-3xl bg-white/10 p-5"><div class="text-3xl font-black text-orange-400">COD</div><p class="mt-2 text-sm text-zinc-400">thanh toán khi nhận</p></div>
            </div>
        </div>
    </div>
</section>

<section class="bh-container py-12">
    <form method="GET" class="bh-card mb-8 grid gap-3 p-4 md:grid-cols-4">
        <input name="q" value="{{ request('q') }}" class="bh-input md:col-span-2" placeholder="Tìm sản phẩm, thương hiệu...">
        <select name="loai_san_pham" class="bh-input">
            <option value="">Tất cả loại</option>
            @foreach($loaiSanPham as $value => $label)
                <option value="{{ $value }}" @selected(request('loai_san_pham') === $value)>{{ $label }}</option>
            @endforeach
        </select>
        <select name="sap_xep" class="bh-input">
            <option value="">Mới / nổi bật</option>
            <option value="gia_tang" @selected(request('sap_xep') === 'gia_tang')>Giá tăng dần</option>
            <option value="gia_giam" @selected(request('sap_xep') === 'gia_giam')>Giá giảm dần</option>
        </select>
        <button class="bh-btn-primary md:col-span-4">Lọc sản phẩm</button>
    </form>

    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
        @forelse($sanPham as $sp)
            <article class="group bh-card overflow-hidden transition duration-300 hover:-translate-y-2">
                <a href="{{ route('public.san-pham.show', $sp) }}" class="relative block h-52 overflow-hidden bg-black/40">
                    <div class="absolute inset-5 grid place-items-center rounded-[1.8rem] bg-[radial-gradient(circle_at_55%_25%,rgba(255,106,42,.72),transparent_25%),radial-gradient(circle_at_45%_55%,rgba(183,43,255,.55),transparent_45%),rgba(255,255,255,.06)] text-5xl font-black text-white transition group-hover:scale-105">{{ mb_substr($sp->ten_san_pham,0,1) }}</div>
                    @if($sp->gia_khuyen_mai)
                        <span class="absolute left-4 top-4 rounded-full bg-red-500 px-3 py-1 text-xs font-black text-white">Sale</span>
                    @endif
                </a>
                <div class="p-5">
                    <p class="text-xs font-black uppercase tracking-[.22em] text-zinc-500">{{ $sp->thuong_hieu ?? 'Barber House' }}</p>
                    <a href="{{ route('public.san-pham.show', $sp) }}" class="mt-2 block text-lg font-black leading-tight text-white hover:text-red-300">{{ $sp->ten_san_pham }}</a>
                    <p class="mt-2 line-clamp-2 text-sm text-zinc-400">{{ $sp->mo_ta_ngan }}</p>
                    <div class="mt-5 flex items-end justify-between gap-3">
                        <div>
                            <div class="text-xl font-black text-orange-400">{{ number_format($sp->gia_ban) }}đ</div>
                            @if($sp->gia_khuyen_mai)
                                <div class="text-xs text-zinc-600 line-through">{{ number_format($sp->gia) }}đ</div>
                            @endif
                        </div>
                        <form method="POST" action="{{ route('public.gio-hang.add', $sp) }}">
                            @csrf
                            <button class="rounded-full bg-white px-4 py-3 text-xs font-black text-black transition hover:bg-red-500 hover:text-white">Thêm</button>
                        </form>
                    </div>
                </div>
            </article>
        @empty
            <div class="bh-card p-12 text-center font-bold text-zinc-400 sm:col-span-2 lg:col-span-4">Chưa có sản phẩm phù hợp.</div>
        @endforelse
    </div>

    <div class="mt-10">{{ $sanPham->links() }}</div>
</section>
@endsection
