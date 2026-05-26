@extends('user.layouts.app')
@section('title', 'Đánh giá của tôi - Barber House')
@section('content')
<section class="hero-bg py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <p class="text-orange-500 font-black uppercase tracking-widest text-sm">Review</p>
        <h1 class="section-title mt-3">Đánh giá của tôi</h1>
    </div>
</section>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="space-y-4">
        @forelse($danhGia as $dg)
            <div class="glass rounded-[2rem] p-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <div class="text-yellow-400 text-xl">{{ str_repeat('★', (int) $dg->so_sao) }}</div>
                    <h2 class="text-xl font-black mt-2">{{ $dg->lichHen->ma_lich_hen ?? '-' }} • {{ $dg->tho->ho_ten ?? '-' }}</h2>
                    <p class="text-slate-600 mt-2">{{ $dg->noi_dung ?? 'Không có nội dung.' }}</p>
                </div>
                <x-badge-status :status="$dg->trang_thai" />
            </div>
        @empty
            <div class="glass rounded-[2rem] p-12 text-center text-slate-500">Bạn chưa có đánh giá nào.</div>
        @endforelse
    </div>
    <div class="mt-8">{{ $danhGia->links() }}</div>
</section>
@endsection
