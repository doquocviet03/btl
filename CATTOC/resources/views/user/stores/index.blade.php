@extends('user.layouts.app')
@section('title', 'Hệ thống cửa hàng Barber House')
@section('meta_description', 'Tìm cửa hàng Barber House gần bạn để đặt lịch cắt tóc, chăm sóc tóc hoặc mua sản phẩm trực tiếp tại các chi nhánh.')
@section('content')
<section class="bh-page-hero">
    <div class="bh-container grid gap-8 lg:grid-cols-[1fr_.42fr] lg:items-end">
        <div>
            <p class="bh-eyebrow">Store System</p>
            <h1 class="bh-section-title mt-4 max-w-5xl">Hệ thống Barber House tại Việt Nam.</h1>
            <p class="mt-5 max-w-2xl text-zinc-400">Tìm chi nhánh gần bạn để đặt lịch cắt tóc, chăm sóc tóc hoặc mua sản phẩm trực tiếp.</p>
        </div>
        <form method="GET" class="bh-card grid gap-3 p-4">
            <input name="q" value="{{ request('q') }}" class="bh-input" placeholder="Tìm địa chỉ hoặc tên chi nhánh...">
            <select name="thanh_pho" class="bh-input">
                <option value="">Tất cả thành phố</option>
                @foreach($thanhPho as $city)
                    <option value="{{ $city }}" @selected(request('thanh_pho') === $city)>{{ $city }}</option>
                @endforeach
            </select>
            <button class="bh-btn-primary">Lọc cửa hàng</button>
        </form>
    </div>
</section>

<section class="bh-container grid gap-8 py-12 lg:grid-cols-[.55fr_1fr]">
    <div class="bh-dark-card h-fit p-8 lg:sticky lg:top-28">
        <p class="bh-eyebrow">Map Preview</p>
        <h2 class="mt-4 text-4xl font-black leading-[.95] tracking-[-.06em] text-white">Phủ sóng các thành phố lớn.</h2>
        <p class="mt-5 text-zinc-400">Bạn có thể bổ sung link Google Maps cho từng cửa hàng trong database trường <strong>ban_do_url</strong>.</p>
        <div class="mt-8 grid grid-cols-2 gap-4">
            <div class="rounded-3xl bg-white/10 p-5"><div class="text-3xl font-black text-orange-400">{{ $cuaHang->total() }}</div><p class="mt-2 text-sm text-zinc-400">chi nhánh</p></div>
            <div class="rounded-3xl bg-white/10 p-5"><div class="text-3xl font-black text-orange-400">08-18</div><p class="mt-2 text-sm text-zinc-400">giờ mở cửa</p></div>
        </div>
    </div>
    <div class="space-y-4">
        @forelse($cuaHang as $store)
            <article class="bh-card grid gap-5 p-6 md:grid-cols-[1fr_auto] md:items-center">
                <div>
                    <div class="flex flex-wrap items-center gap-2">
                        <h2 class="text-2xl font-black tracking-[-.04em] text-white">{{ $store->ten_cua_hang }}</h2>
                        <span class="bh-chip">{{ $store->thanh_pho }}</span>
                    </div>
                    <p class="mt-3 font-bold text-zinc-300">{{ $store->dia_chi }}</p>
                    <p class="mt-2 text-sm text-zinc-500">{{ $store->mo_ta }}</p>
                    <div class="mt-4 flex flex-wrap gap-3 text-sm font-black text-zinc-400">
                        <span>☎ {{ $store->so_dien_thoai ?? 'Đang cập nhật' }}</span>
                        <span>•</span>
                        <span>{{ $store->gio_mo_cua }}</span>
                    </div>
                </div>
                <div class="flex gap-3 md:flex-col">
                    @if($store->ban_do_url)
                        <a href="{{ $store->ban_do_url }}" target="_blank" class="bh-btn-light">Bản đồ</a>
                    @endif
                    <a href="{{ route('public.dat-lich.index') }}" class="bh-btn-primary">Đặt lịch</a>
                </div>
            </article>
        @empty
            <div class="bh-card p-12 text-center font-bold text-zinc-400">Chưa tìm thấy cửa hàng phù hợp.</div>
        @endforelse
        <div class="mt-8">{{ $cuaHang->links() }}</div>
    </div>
</section>
@endsection
