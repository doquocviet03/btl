@extends('user.layouts.app')
@section('title', $baiViet->tieu_de . ' - Barber House')
@section('content')
<section class="hero-gradient py-16">
    <div class="bh-container max-w-4xl text-center">
        <p class="bh-eyebrow">{{ $baiViet->tac_gia }} • {{ optional($baiViet->xuat_ban_luc)->format('d/m/Y') }}</p>
        <h1 class="bh-section-title mt-4">{{ $baiViet->tieu_de }}</h1>
        <p class="bh-muted mt-6">{{ $baiViet->tom_tat }}</p>
    </div>
</section>
<section class="bh-container py-12 grid lg:grid-cols-[1fr_.35fr] gap-8">
    <article class="bh-card p-8 md:p-10">
        {{-- UI NOTE: Nội dung blog dùng whitespace-pre-line để xuống dòng theo database. --}}
        <div class="text-lg leading-8 text-slate-700 whitespace-pre-line">{{ $baiViet->noi_dung }}</div>
    </article>
    <aside class="space-y-4">
        <div class="bh-dark-card p-6">
            <h3 class="text-xl font-black">Cần tư vấn kiểu tóc?</h3>
            <p class="text-slate-400 mt-2 text-sm">Đặt lịch với thợ để được tư vấn theo khuôn mặt và chất tóc.</p>
            <a href="{{ route('public.dat-lich.index') }}" class="bh-btn-primary mt-5 w-full">Đặt lịch</a>
        </div>
        @foreach($baiVietLienQuan as $post)
            <a href="{{ route('public.blog.show', $post) }}" class="block bh-card p-5 hover:border-orange-300 transition">
                <div class="text-xs font-black text-orange-500">Bài liên quan</div>
                <div class="font-black mt-2 leading-tight">{{ $post->tieu_de }}</div>
            </a>
        @endforeach
    </aside>
</section>
@endsection
