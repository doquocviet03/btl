@extends('user.layouts.app')
@section('title', $thoCatToc->ho_ten . ' - Barber House')
@section('meta_description', 'Thông tin barber ' . $thoCatToc->ho_ten . ', lịch làm việc gần nhất, đánh giá khách hàng và đặt lịch cắt tóc nhanh tại Barber House.')
@section('content')
<section class="bh-page-hero">
    <div class="bh-container grid items-center gap-10 lg:grid-cols-[1fr_.82fr]">
        <div>
            <a href="{{ route('public.tho-cat-toc.index') }}" class="text-sm font-black text-zinc-400 hover:text-white">← Quay lại danh sách thợ</a>
            <p class="bh-eyebrow mt-7">Professional Barber</p>
            <h1 class="bh-section-title mt-4 max-w-4xl">{{ $thoCatToc->ho_ten }}</h1>
            <p class="mt-6 max-w-2xl text-lg leading-relaxed text-zinc-300">{{ $thoCatToc->mo_ta ?? 'Thợ cắt tóc chuyên nghiệp, tư vấn kiểu tóc phù hợp khuôn mặt và phong cách cá nhân.' }}</p>
            <div class="mt-8 grid max-w-xl grid-cols-2 gap-4">
                <div class="bh-mini-card"><p class="text-sm text-zinc-500">Kinh nghiệm</p><strong class="text-2xl font-black text-white">{{ $thoCatToc->kinh_nghiem }} năm</strong></div>
                <div class="bh-mini-card"><p class="text-sm text-zinc-500">Chuyên môn</p><strong class="text-lg font-black text-white">{{ $thoCatToc->chuyen_mon ?? 'Cắt tóc nam' }}</strong></div>
            </div>
            <a href="{{ route('public.dat-lich.index', ['tho_id' => $thoCatToc->id]) }}" class="bh-btn-primary mt-8">Đặt với thợ này</a>
        </div>
        <div class="bh-dark-card relative min-h-[30rem] overflow-hidden p-8">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_18%,rgba(255,53,53,.76),transparent_24%),radial-gradient(circle_at_48%_45%,rgba(183,43,255,.62),transparent_44%)]"></div>
            <div class="relative z-10 flex h-full flex-col justify-between">
                <div class="flex justify-between"><span class="bh-chip">Barber House</span><span class="bh-chip">{{ $thoCatToc->kinh_nghiem }}Y EXP</span></div>
                <div>
                    <p class="text-8xl font-black tracking-[-.1em] text-white/80">PRO</p>
                    <p class="mt-4 max-w-sm text-zinc-300">Tập trung vào trải nghiệm rõ ràng: đúng giờ, tư vấn kỹ, cắt gọn và chăm tóc sau dịch vụ.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="bh-container py-14 grid gap-6 lg:grid-cols-[.8fr_1.2fr]">
    <div class="bh-card h-fit p-6">
        <h2 class="text-3xl font-black tracking-[-.05em] text-white">Lịch làm việc gần nhất</h2>
        <div class="mt-6 space-y-3">
            @forelse($thoCatToc->lichLamViec as $lich)
                <div class="flex justify-between rounded-2xl border border-white/10 bg-white/[.06] px-4 py-3 text-sm text-zinc-300">
                    <span>{{ $lich->ngay_lam?->format('d/m/Y') }}</span>
                    <strong class="text-white">{{ substr($lich->gio_bat_dau,0,5) }} - {{ substr($lich->gio_ket_thuc,0,5) }}</strong>
                </div>
            @empty
                <p class="text-zinc-500">Chưa có lịch làm việc sắp tới.</p>
            @endforelse
        </div>
    </div>
    <div class="bh-card p-6">
        <h2 class="text-3xl font-black tracking-[-.05em] text-white">Đánh giá khách hàng</h2>
        <div class="mt-6 space-y-4">
            @forelse($danhGia as $dg)
                <div class="rounded-2xl border border-white/10 bg-white/[.06] p-4">
                    <div class="text-orange-400">{{ str_repeat('★', (int) $dg->so_sao) }}</div>
                    <p class="mt-2 text-zinc-300">{{ $dg->noi_dung ?? 'Dịch vụ tốt.' }}</p>
                    <p class="mt-3 text-sm font-black text-white">{{ $dg->khachHang->ho_ten ?? 'Khách hàng' }}</p>
                </div>
            @empty
                <p class="text-zinc-500">Chưa có đánh giá.</p>
            @endforelse
        </div>
        <div class="mt-8">{{ $danhGia->links() }}</div>
    </div>
</section>
@endsection
