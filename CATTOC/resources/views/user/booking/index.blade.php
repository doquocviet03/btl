@extends('user.layouts.app')
@section('title', 'Đặt lịch cắt tóc online - Barber House')
@section('meta_description', 'Đặt lịch cắt tóc online tại Barber House: chọn dịch vụ, chọn barber, ngày giờ, phương thức thanh toán và theo dõi lịch hẹn dễ dàng.')

@section('content')
@php
    $selectedServices = array_map('intval', (array) old('dich_vu_ids', request()->input('dich_vu_ids', [])));
    $selectedTho = old('tho_id', request('tho_id'));
@endphp
<section class="bh-page-hero">
    <div class="bh-container grid gap-8 lg:grid-cols-[1fr_.45fr] lg:items-end">
        <div>
            <p class="bh-eyebrow">Smart Booking</p>
            <h1 class="bh-section-title mt-4 max-w-5xl">Đặt lịch cắt tóc nhanh, không chờ đợi.</h1>
            <p class="mt-5 max-w-2xl text-zinc-400">Chọn dịch vụ, barber và thời gian. Hệ thống giữ nguyên logic kiểm tra lịch làm việc, tránh trùng lịch và tạo thanh toán tự động.</p>
        </div>
        <div class="bh-card p-5">
            <p class="text-sm font-bold text-zinc-400">Quy trình</p>
            <div class="mt-4 grid grid-cols-3 gap-3 text-center text-xs font-black">
                <span class="rounded-2xl bg-white px-3 py-3 text-black">Dịch vụ</span>
                <span class="rounded-2xl bg-white/10 px-3 py-3 text-white">Barber</span>
                <span class="rounded-2xl bg-white/10 px-3 py-3 text-white">Thanh toán</span>
            </div>
        </div>
    </div>
</section>

<section class="bh-container py-12">
    <form method="POST" action="{{ route('public.dat-lich.store') }}" class="grid gap-6 lg:grid-cols-3" id="bookingForm">
        @csrf
        <div class="space-y-6 lg:col-span-2">
            <div class="bh-card p-6">
                <div class="mb-5 flex items-center gap-3">
                    <span class="grid h-10 w-10 place-items-center rounded-2xl bg-white text-black font-black">01</span>
                    <h2 class="text-2xl font-black tracking-[-.04em] text-white">Thông tin khách hàng</h2>
                </div>
                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="bh-label">Họ tên</label>
                        <input name="ho_ten" value="{{ old('ho_ten', $khachHang->ho_ten ?? auth()->user()?->ho_ten ?? '') }}" class="bh-input" required>
                    </div>
                    <div>
                        <label class="bh-label">Số điện thoại</label>
                        <input name="so_dien_thoai" value="{{ old('so_dien_thoai', $khachHang->so_dien_thoai ?? auth()->user()?->so_dien_thoai ?? '') }}" class="bh-input" required>
                    </div>
                    <div class="md:col-span-2">
                        <label class="bh-label">Email</label>
                        <input type="email" name="email" value="{{ old('email', $khachHang->email ?? auth()->user()?->email ?? '') }}" class="bh-input">
                    </div>
                </div>
            </div>

            <div class="bh-card p-6">
                <div class="mb-5 flex items-center gap-3">
                    <span class="grid h-10 w-10 place-items-center rounded-2xl bg-white text-black font-black">02</span>
                    <h2 class="text-2xl font-black tracking-[-.04em] text-white">Chọn dịch vụ</h2>
                </div>
                <div class="grid gap-4 md:grid-cols-2">
                    @forelse($dichVu as $dv)
                        <label class="group cursor-pointer rounded-[1.5rem] border border-white/10 bg-white/[.055] p-4 transition hover:border-red-400/60 hover:bg-white/[.09] has-[:checked]:border-red-500 has-[:checked]:bg-red-500/10">
                            <div class="flex items-start gap-3">
                                <input type="checkbox" name="dich_vu_ids[]" value="{{ $dv->id }}" data-price="{{ $dv->gia }}" data-time="{{ $dv->thoi_gian }}" class="service-checkbox mt-1 rounded border-white/20 bg-black text-red-500 focus:ring-red-500" @checked(in_array($dv->id, $selectedServices))>
                                <div class="flex-1">
                                    <div class="font-black text-white">{{ $dv->ten_dich_vu }}</div>
                                    <div class="mt-1 text-sm text-zinc-500">{{ $dv->thoi_gian }} phút</div>
                                    <div class="mt-3 text-xl font-black text-orange-400">{{ number_format($dv->gia) }}đ</div>
                                </div>
                            </div>
                        </label>
                    @empty
                        <p class="text-zinc-500">Chưa có dịch vụ đang hoạt động.</p>
                    @endforelse
                </div>
            </div>

            <div class="bh-card p-6">
                <div class="mb-5 flex items-center gap-3">
                    <span class="grid h-10 w-10 place-items-center rounded-2xl bg-white text-black font-black">03</span>
                    <h2 class="text-2xl font-black tracking-[-.04em] text-white">Chọn thợ và thời gian</h2>
                </div>
                <div class="grid gap-4 md:grid-cols-3">
                    <div>
                        <label class="bh-label">Thợ cắt tóc</label>
                        <select name="tho_id" class="bh-input" required>
                            <option value="">-- Chọn thợ --</option>
                            @foreach($thoCatToc as $tho)
                                <option value="{{ $tho->id }}" @selected($selectedTho == $tho->id)>{{ $tho->ho_ten }} - {{ $tho->chuyen_mon }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="bh-label">Ngày hẹn</label>
                        <input type="date" name="ngay_hen" value="{{ old('ngay_hen', now()->toDateString()) }}" min="{{ now()->toDateString() }}" class="bh-input" required>
                    </div>
                    <div>
                        <label class="bh-label">Giờ bắt đầu</label>
                        <input type="time" name="gio_bat_dau" value="{{ old('gio_bat_dau', '08:00') }}" class="bh-input" required>
                    </div>
                    <div class="md:col-span-3">
                        <label class="bh-label">Ghi chú</label>
                        <textarea name="ghi_chu" rows="4" class="bh-input" placeholder="Ví dụ: muốn cắt fade thấp, tóc dày...">{{ old('ghi_chu') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <aside class="lg:sticky lg:top-24 h-fit">
            <div class="bh-dark-card overflow-hidden p-6">
                <div class="relative">
                    <div class="absolute -right-20 -top-20 h-52 w-52 rounded-full bg-red-500/25 blur-3xl"></div>
                    <div class="relative">
                        <p class="bh-eyebrow">Summary</p>
                        <h2 class="mt-4 text-3xl font-black tracking-[-.05em] text-white">Tóm tắt lịch hẹn</h2>
                        <div class="mt-6 space-y-4">
                            <div class="flex justify-between border-b border-white/10 pb-3"><span class="text-zinc-400">Tổng tiền</span><strong id="totalMoney" class="text-2xl font-black text-orange-400">0đ</strong></div>
                            <div class="flex justify-between border-b border-white/10 pb-3"><span class="text-zinc-400">Tổng thời gian</span><strong id="totalTime" class="text-white">0 phút</strong></div>
                            <div>
                                <label class="bh-label">Phương thức thanh toán</label>
                                <select name="phuong_thuc" class="bh-input" required>
                                    <option value="tien_mat" @selected(old('phuong_thuc')=='tien_mat')>Tiền mặt tại cửa hàng</option>
                                    <option value="chuyen_khoan" @selected(old('phuong_thuc')=='chuyen_khoan')>Chuyển khoản</option>
                                    <option value="vi_dien_tu" @selected(old('phuong_thuc')=='vi_dien_tu')>Ví điện tử khác</option>
                                    <option value="vnpay" @selected(old('phuong_thuc')=='vnpay')>VNPAY Sandbox</option>
                                    <option value="momo" @selected(old('phuong_thuc')=='momo')>MoMo Demo/QR</option>
                                </select>
                            </div>
                        </div>
                        <button class="bh-btn-primary mt-7 w-full">Xác nhận đặt lịch</button>
                        <p class="mt-4 text-xs leading-relaxed text-zinc-500">Sau khi đặt lịch, admin sẽ xác nhận và bạn có thể theo dõi trong mục “Lịch của tôi”.</p>
                    </div>
                </div>
            </div>
        </aside>
    </form>
</section>
@endsection

@push('scripts')
<script>
    const money = new Intl.NumberFormat('vi-VN');
    function updateSummary() {
        let total = 0, time = 0;
        document.querySelectorAll('.service-checkbox:checked').forEach(el => {
            total += Number(el.dataset.price || 0);
            time += Number(el.dataset.time || 0);
        });
        document.getElementById('totalMoney').textContent = money.format(total) + 'đ';
        document.getElementById('totalTime').textContent = time + ' phút';
    }
    document.querySelectorAll('.service-checkbox').forEach(el => el.addEventListener('change', updateSummary));
    updateSummary();
</script>
@endpush
