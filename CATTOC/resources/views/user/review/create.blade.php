@extends('user.layouts.app')
@section('title', 'Đánh giá dịch vụ - Barber House')
@section('content')
<section class="hero-bg py-14">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <p class="text-orange-500 font-black uppercase tracking-widest text-sm">Review</p>
        <h1 class="section-title mt-3">Đánh giá dịch vụ</h1>
    </div>
</section>

<section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <form method="POST" action="{{ route('public.danh-gia.store', $lichHen) }}" class="glass rounded-[2rem] p-6 md:p-8">
        @csrf
        <div class="rounded-3xl bg-white border border-slate-100 p-5 mb-6">
            <h2 class="text-2xl font-black">{{ $lichHen->ma_lich_hen }}</h2>
            <p class="text-slate-500 mt-2">Thợ: <strong>{{ $lichHen->tho->ho_ten ?? '-' }}</strong> • {{ $lichHen->ngay_hen?->format('d/m/Y') }}</p>
            <div class="mt-4 flex flex-wrap gap-2">
                @foreach($lichHen->chiTiet as $ct)
                    <span class="px-3 py-1 rounded-full bg-orange-50 text-orange-700 text-sm font-bold">{{ $ct->ten_dich_vu }}</span>
                @endforeach
            </div>
        </div>

        <label class="font-black text-lg">Số sao</label>
        <select name="so_sao" class="soft-input mt-2 w-full" required>
            <option value="5">★★★★★ - Rất hài lòng</option>
            <option value="4">★★★★ - Hài lòng</option>
            <option value="3">★★★ - Bình thường</option>
            <option value="2">★★ - Chưa tốt</option>
            <option value="1">★ - Không hài lòng</option>
        </select>

        <label class="font-black text-lg block mt-6">Nội dung</label>
        <textarea name="noi_dung" rows="6" class="soft-input mt-2 w-full" placeholder="Chia sẻ cảm nhận của bạn...">{{ old('noi_dung') }}</textarea>

        <div class="mt-7 flex justify-end gap-3">
            <a href="{{ route('public.lich-cua-toi') }}" class="px-5 py-3 rounded-2xl border border-slate-200 font-bold">Quay lại</a>
            <button class="px-6 py-3 rounded-2xl bg-orange-500 text-white font-black hover:bg-slate-950 transition">Gửi đánh giá</button>
        </div>
    </form>
</section>
@endsection
