@extends('user.layouts.app')
@section('title', 'Barber House - Đặt lịch cắt tóc nam cao cấp')
@section('meta_description', 'Barber House là website đặt lịch cắt tóc nam cao cấp, chọn barber, xem dịch vụ, thanh toán online và mua sản phẩm chăm sóc tóc chuẩn salon.')
@section('content')
<section class="bh-container py-6 md:py-8">
    <div class="bh-hero-card">
        <div class="jelly-wrap">
            <div class="jelly-core"></div>
            <span class="jelly-tentacle"></span>
            <span class="jelly-tentacle"></span>
            <span class="jelly-tentacle"></span>
            <span class="jelly-tentacle"></span>
            <span class="jelly-tentacle"></span>
        </div>

        <div class="relative z-10 flex min-h-[calc(100vh-13rem)] flex-col justify-between gap-10">
            <div class="flex items-center justify-between gap-4">
                <p class="bh-eyebrow">Premium Barber Booking</p>
                <a href="{{ route('public.dat-lich.index') }}" class="hidden rounded-full bg-white px-5 py-2.5 text-xs font-black text-black shadow-[0_16px_45px_rgba(255,255,255,.12)] transition hover:scale-105 md:inline-flex">Book now</a>
            </div>

            <div class="grid items-end gap-10 lg:grid-cols-[1.05fr_.95fr]">
                <div>
                    <div class="mb-6 inline-flex rounded-full border border-white/10 bg-black/35 px-3 py-2 text-xs font-bold text-zinc-400 backdrop-blur-xl">
                        Website đặt lịch cắt tóc, thanh toán online & chăm sóc tóc nam
                    </div>
                    <h1 class="max-w-4xl text-6xl font-black leading-[.82] tracking-[-.09em] text-white sm:text-7xl lg:text-8xl xl:text-9xl">
                        Digital barber experience that <span class="bh-gradient-text">moves deeper</span>.
                    </h1>
                    <p class="mt-6 max-w-xl text-base leading-relaxed text-zinc-300 md:text-lg">
                        Barber House giúp bạn chọn dịch vụ, chọn thợ, giữ lịch, thanh toán và mua sản phẩm chăm sóc tóc trong một hành trình mượt, nhanh, rõ ràng.
                    </p>
                    <div class="mt-8 flex flex-wrap gap-3">
                        <a href="{{ route('public.dat-lich.index') }}" class="bh-btn-primary">Đặt lịch ngay</a>
                        <a href="{{ route('public.dich-vu.index') }}" class="bh-btn-dark">Khám phá dịch vụ</a>
                    </div>
                </div>

                <div class="grid gap-4 md:grid-cols-[.8fr_1fr] lg:block">
                    <div class="ml-auto max-w-sm rounded-[2rem] border border-white/10 bg-white/[.08] p-4 backdrop-blur-2xl">
                        <div class="h-44 overflow-hidden rounded-[1.5rem] bg-black/40 relative">
                            <div class="absolute inset-0 bg-[radial-gradient(circle_at_55%_25%,rgba(255,53,53,.72),transparent_22%),radial-gradient(circle_at_44%_42%,rgba(183,43,255,.72),transparent_35%),linear-gradient(145deg,rgba(255,255,255,.12),transparent)]"></div>
                            <div class="absolute bottom-4 left-4 right-4 flex items-end justify-between">
                                <div>
                                    <p class="text-xs font-bold text-zinc-400">Today slot</p>
                                    <p class="text-3xl font-black text-white">08:30</p>
                                </div>
                                <span class="rounded-full bg-red-500 px-4 py-2 text-xs font-black text-white">Live</span>
                            </div>
                        </div>
                        <div class="mt-4 grid grid-cols-2 gap-3">
                            <div class="rounded-3xl bg-white/90 p-4 text-black">
                                <p class="text-3xl font-black">{{ $dichVuNoiBat->count() }}+</p>
                                <p class="text-xs font-bold text-zinc-500">dịch vụ nổi bật</p>
                            </div>
                            <div class="rounded-3xl bg-white/10 p-4">
                                <p class="text-3xl font-black text-white">{{ $thoCatToc->count() }}+</p>
                                <p class="text-xs font-bold text-zinc-400">barber sẵn sàng</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 grid grid-cols-3 gap-3">
                        <div class="bh-mini-card"><p class="text-2xl font-black text-white">95%</p><span class="text-xs font-bold text-zinc-500">đặt nhanh</span></div>
                        <div class="bh-mini-card"><p class="text-2xl font-black text-white">{{ $soCuaHang }}+</p><span class="text-xs font-bold text-zinc-500">cửa hàng</span></div>
                        <div class="bh-mini-card"><p class="text-2xl font-black text-white">4.9</p><span class="text-xs font-bold text-zinc-500">trải nghiệm</span></div>
                    </div>
                </div>
            </div>

            <div class="grid gap-4 md:grid-cols-4">
                <div class="rounded-[1.6rem] border border-white/10 bg-white/[.07] p-5 backdrop-blur-xl md:col-span-2">
                    <p class="text-sm text-zinc-400">We are a <span class="text-white">full-cycle</span> barber platform that dives deep into booking, payment and personal style care.</p>
                </div>
                <div class="rounded-[1.6rem] border border-white/10 bg-white/[.07] p-5 backdrop-blur-xl">
                    <p class="text-2xl font-black text-white">01</p>
                    <p class="mt-3 text-sm text-zinc-400">Đặt lịch không chờ đợi.</p>
                </div>
                <div class="rounded-[1.6rem] border border-white/10 bg-white/[.07] p-5 backdrop-blur-xl">
                    <p class="text-2xl font-black bh-gradient-text">02</p>
                    <p class="mt-3 text-sm text-zinc-400">Thanh toán online linh hoạt.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="bh-container py-14">
    <div class="mb-8 flex flex-col justify-between gap-4 md:flex-row md:items-end">
        <div>
            <p class="bh-eyebrow">Signature Services</p>
            <h2 class="mt-4 max-w-4xl text-5xl font-black leading-[.9] tracking-[-.07em] text-white md:text-7xl">
                We don’t sell a set of services. We choose <span class="bh-gradient-text">the tools for your style</span>.
            </h2>
        </div>
        <a href="{{ route('public.dich-vu.index') }}" class="bh-btn-light shrink-0">Xem tất cả</a>
    </div>

    <div class="grid gap-5 md:grid-cols-3">
        @forelse($dichVuNoiBat->take(6) as $index => $dv)
            <a href="{{ route('public.dich-vu.show', $dv) }}" class="group bh-card p-6 transition duration-300 hover:-translate-y-2">
                <div class="flex items-start justify-between gap-5">
                    <span class="text-4xl font-black tracking-[-.08em] {{ $index === 1 ? 'bh-gradient-text' : 'text-white' }}">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                    <span class="bh-chip">{{ $dv->thoi_gian }} phút</span>
                </div>
                <h3 class="mt-8 text-2xl font-black leading-tight tracking-[-.04em] text-white group-hover:text-red-300">{{ $dv->ten_dich_vu }}</h3>
                <p class="mt-3 line-clamp-3 text-sm leading-relaxed text-zinc-400">{{ $dv->mo_ta ?? 'Dịch vụ chăm sóc tóc chuyên nghiệp, thiết kế theo khuôn mặt và phong cách cá nhân.' }}</p>
                <div class="mt-8 flex items-end justify-between">
                    <strong class="bh-price">{{ number_format($dv->gia) }}đ</strong>
                    <span class="rounded-full bg-white px-4 py-2 text-xs font-black text-black opacity-0 transition group-hover:opacity-100">Chi tiết</span>
                </div>
            </a>
        @empty
            <div class="bh-card p-10 text-center text-zinc-400 md:col-span-3">Chưa có dịch vụ nào.</div>
        @endforelse
    </div>
</section>

<section class="bh-container py-14">
    <div class="bh-section-dark p-6 md:p-10">
        <div class="grid items-center gap-10 lg:grid-cols-[.8fr_1.2fr]">
            <div>
                <p class="bh-eyebrow">Barber Team</p>
                <h2 class="mt-4 text-5xl font-black leading-[.9] tracking-[-.07em] text-white md:text-7xl">Your style sprint team on demand.</h2>
                <p class="mt-5 text-zinc-400">Chọn thợ theo chuyên môn, kinh nghiệm và phong cách. Mỗi lịch hẹn đều được ghi nhận rõ ràng để bạn dễ theo dõi.</p>
                <a href="{{ route('public.tho-cat-toc.index') }}" class="bh-btn-primary mt-7">Xem đội ngũ</a>
            </div>
            <div class="grid gap-4 sm:grid-cols-2">
                @forelse($thoCatToc as $tho)
                    <a href="{{ route('public.tho-cat-toc.show', $tho) }}" class="group rounded-[2rem] border border-white/10 bg-black/30 p-5 transition hover:bg-white hover:text-black">
                        <div class="h-44 rounded-[1.5rem] bg-[radial-gradient(circle_at_50%_20%,rgba(255,53,53,.8),transparent_25%),radial-gradient(circle_at_50%_45%,rgba(183,43,255,.6),transparent_45%),rgba(255,255,255,.06)] grid place-items-center text-6xl font-black text-white group-hover:text-black">
                            {{ mb_substr($tho->ho_ten,0,1) }}
                        </div>
                        <h3 class="mt-5 text-xl font-black tracking-[-.04em]">{{ $tho->ho_ten }}</h3>
                        <p class="mt-1 text-sm text-zinc-400 group-hover:text-zinc-600">{{ $tho->chuyen_mon ?? 'Barber chuyên nghiệp' }}</p>
                        <div class="mt-4 flex justify-between text-sm font-black">
                            <span>{{ $tho->kinh_nghiem }} năm KN</span>
                            <span>{{ $tho->lich_hen_count }} lịch</span>
                        </div>
                    </a>
                @empty
                    <div class="rounded-[2rem] border border-white/10 p-8 text-zinc-400 sm:col-span-2">Chưa có thợ cắt tóc.</div>
                @endforelse
            </div>
        </div>
    </div>
</section>

@if($sanPhamNoiBat->count())
<section class="bh-container py-14">
    <div class="mb-8 flex flex-col justify-between gap-4 md:flex-row md:items-end">
        <div>
            <p class="bh-eyebrow">Hair Care Shop</p>
            <h2 class="mt-4 text-5xl font-black tracking-[-.07em] text-white md:text-7xl">Sản phẩm giữ form tóc sau salon.</h2>
        </div>
        <a href="{{ route('public.san-pham.index') }}" class="bh-btn-light shrink-0">Mua sản phẩm</a>
    </div>
    <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
        @foreach($sanPhamNoiBat as $sp)
            <a href="{{ route('public.san-pham.show', $sp) }}" class="bh-card overflow-hidden transition hover:-translate-y-2">
                <div class="relative h-44 bg-black/30">
                    <div class="absolute inset-5 rounded-[1.6rem] bg-[radial-gradient(circle_at_55%_25%,rgba(255,106,42,.72),transparent_25%),radial-gradient(circle_at_45%_55%,rgba(183,43,255,.55),transparent_45%),rgba(255,255,255,.06)] grid place-items-center text-5xl font-black text-white">{{ mb_substr($sp->ten_san_pham,0,1) }}</div>
                </div>
                <div class="p-5">
                    <p class="text-xs font-black uppercase tracking-[.22em] text-zinc-500">{{ $sp->thuong_hieu ?? 'Barber House' }}</p>
                    <h3 class="mt-2 line-clamp-2 font-black text-white">{{ $sp->ten_san_pham }}</h3>
                    <p class="mt-3 text-xl font-black text-orange-400">{{ number_format($sp->gia_ban) }}đ</p>
                </div>
            </a>
        @endforeach
    </div>
</section>
@endif

@if($baiVietMoi->count())
<section class="bh-container py-14">
    <div class="bh-section-dark p-6 md:p-10">
        <div class="mb-8 flex flex-col justify-between gap-4 md:flex-row md:items-end">
            <div>
                <p class="bh-eyebrow">SEO Journal</p>
                <h2 class="mt-4 text-5xl font-black tracking-[-.07em] text-white md:text-7xl">Nội dung có chất riêng, giữ chân người xem.</h2>
            </div>
            <a href="{{ route('public.blog.index') }}" class="bh-btn-primary shrink-0">Xem blog</a>
        </div>
        <div class="grid gap-5 md:grid-cols-3">
            @foreach($baiVietMoi as $post)
                <a href="{{ route('public.blog.show', $post) }}" class="rounded-[2rem] border border-white/10 bg-white/[.06] p-6 transition hover:bg-white hover:text-black">
                    <p class="text-xs font-black uppercase tracking-[.24em] text-red-300">{{ optional($post->xuat_ban_luc)->format('d/m/Y') ?? 'Journal' }}</p>
                    <h3 class="mt-4 text-2xl font-black leading-tight tracking-[-.05em]">{{ $post->tieu_de }}</h3>
                    <p class="mt-3 line-clamp-3 text-sm text-zinc-400">{{ $post->tom_tat }}</p>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

@if($danhGiaMoi->count())
<section class="bh-container py-14">
    <div class="mb-8">
        <p class="bh-eyebrow">Trusted by clients</p>
        <h2 class="mt-4 text-5xl font-black tracking-[-.07em] text-white md:text-7xl">Khách hàng nói gì?</h2>
    </div>
    <div class="grid gap-5 md:grid-cols-3">
        @foreach($danhGiaMoi->take(6) as $dg)
            <div class="bh-card p-6">
                <div class="text-lg text-orange-400">{{ str_repeat('★', (int) $dg->so_sao) }}</div>
                <p class="mt-4 text-zinc-300">“{{ $dg->noi_dung ?? 'Dịch vụ rất tốt, đặt lịch nhanh và thợ tư vấn kỹ.' }}”</p>
                <div class="mt-6 font-black text-white">{{ $dg->khachHang->ho_ten ?? 'Khách hàng' }}</div>
                <div class="text-sm text-zinc-500">Thợ: {{ $dg->tho->ho_ten ?? '-' }}</div>
            </div>
        @endforeach
    </div>
</section>
@endif
@endsection
