@extends('user.layouts.app')
@section('title', 'Thanh toán - Barber House')
@section('content')
@php
    // UI NOTE: Trang thanh toán user dùng Alpine tabs. Muốn chỉnh màu/nút/card hãy sửa class .bh-* trong resources/css/app.css.
    $thanhToan = $lichHen->thanhToan;
    $momoQrImage = config('momo.static_qr_image');
    $momoReceiver = config('momo.receiver_name');
    $momoPhone = config('momo.receiver_phone');
    $paymentContent = $lichHen->ma_lich_hen;
    $momoConfigured = app(\App\Services\MomoPaymentService::class)->isConfigured();
    $vnpayConfigured = app(\App\Services\VnpayPaymentService::class)->isConfigured();
    $methodLabels = [
        'tien_mat' => 'Tiền mặt',
        'chuyen_khoan' => 'Chuyển khoản',
        'vi_dien_tu' => 'Ví điện tử khác',
        'momo' => 'MoMo Demo/Sandbox',
        'vnpay' => 'VNPAY Sandbox',
    ];
@endphp

<section class="hero-gradient py-14">
    <div class="bh-container">
        <div class="grid lg:grid-cols-[1fr_.42fr] gap-8 items-end">
            <div>
                <p class="bh-eyebrow">Secure Payment</p>
                <h1 class="bh-section-title mt-3">Thanh toán lịch hẹn.</h1>
                <p class="bh-muted mt-5 max-w-2xl">Chọn VNPAY Sandbox để mô phỏng cổng thanh toán chuyên nghiệp, hoặc dùng MoMo Demo/QR tĩnh cho đồ án.</p>
            </div>
            <div class="bh-dark-card p-6">
                <div class="text-sm font-black uppercase tracking-widest text-orange-400">Mã lịch hẹn</div>
                <div class="mt-2 text-3xl font-black tracking-tight">{{ $lichHen->ma_lich_hen }}</div>
                <div class="mt-5 flex items-end justify-between gap-4">
                    <div>
                        <div class="text-sm text-slate-400">Cần thanh toán</div>
                        <div class="text-4xl font-black text-orange-400">{{ number_format($lichHen->tong_tien) }}đ</div>
                    </div>
                    <x-badge-status :status="$thanhToan->trang_thai ?? 'chua_thanh_toan'" />
                </div>
            </div>
        </div>
    </div>
</section>

<section class="bh-container py-12" x-data="{ tab: 'vnpay' }">
    <div class="grid xl:grid-cols-[.42fr_1fr] gap-6">
        <aside class="space-y-5">
            <div class="bh-card p-6">
                <h2 class="text-2xl font-black">Thông tin lịch hẹn</h2>
                <div class="mt-5 space-y-4 text-sm font-bold">
                    <div class="flex justify-between gap-3 border-b border-slate-100 pb-3"><span class="text-slate-400">Khách hàng</span><span class="text-right">{{ $lichHen->khachHang->ho_ten ?? '-' }}</span></div>
                    <div class="flex justify-between gap-3 border-b border-slate-100 pb-3"><span class="text-slate-400">Thợ cắt tóc</span><span class="text-right">{{ $lichHen->tho->ho_ten ?? '-' }}</span></div>
                    <div class="flex justify-between gap-3 border-b border-slate-100 pb-3"><span class="text-slate-400">Ngày giờ</span><span class="text-right">{{ $lichHen->ngay_hen?->format('d/m/Y') }} {{ $lichHen->gio_bat_dau }}</span></div>
                    <div class="flex justify-between gap-3 border-b border-slate-100 pb-3"><span class="text-slate-400">Phương thức</span><span class="text-right">{{ $methodLabels[$thanhToan->phuong_thuc ?? ''] ?? 'Chưa chọn' }}</span></div>
                    <div class="flex justify-between gap-3"><span class="text-slate-400">Nội dung CK</span><span class="text-right font-black text-orange-600">{{ $paymentContent }}</span></div>
                </div>
            </div>

            <div class="bh-card p-5">
                <div class="grid grid-cols-2 gap-3">
                    <button type="button" @click="tab='vnpay'" :class="tab === 'vnpay' ? 'bg-slate-950 text-white' : 'bg-slate-100 text-slate-700'" class="rounded-2xl px-4 py-3 text-sm font-black transition">VNPAY</button>
                    <button type="button" @click="tab='momo'" :class="tab === 'momo' ? 'bg-[#a50064] text-white' : 'bg-slate-100 text-slate-700'" class="rounded-2xl px-4 py-3 text-sm font-black transition">MoMo</button>
                    <button type="button" @click="tab='manual'" :class="tab === 'manual' ? 'bg-orange-500 text-white' : 'bg-slate-100 text-slate-700'" class="rounded-2xl px-4 py-3 text-sm font-black transition col-span-2">Gửi minh chứng thủ công</button>
                </div>
            </div>
        </aside>

        <div class="space-y-6">
            <section x-show="tab === 'vnpay'" x-cloak class="bh-card p-6 lg:p-8">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">
                    <div>
                        <p class="bh-eyebrow">VNPAY Sandbox</p>
                        <h2 class="mt-2 text-3xl font-black tracking-[-.04em]">Thanh toán qua VNPAY</h2>
                        <p class="mt-3 text-slate-500 max-w-2xl">Hệ thống tạo link thanh toán VNPAY Sandbox, chuyển khách sang cổng VNPAY và tự cập nhật trạng thái khi callback hợp lệ.</p>
                    </div>
                    <div class="rounded-2xl {{ $vnpayConfigured ? 'bg-emerald-50 text-emerald-700 border-emerald-100' : 'bg-amber-50 text-amber-700 border-amber-100' }} border px-5 py-3 text-sm font-black">
                        {{ $vnpayConfigured ? 'Đã cấu hình sandbox' : 'Chưa cấu hình sandbox' }}
                    </div>
                </div>

                <div class="mt-6 grid md:grid-cols-3 gap-4">
                    <div class="rounded-[1.5rem] bg-slate-50 border border-slate-100 p-5"><div class="text-xs font-black uppercase tracking-widest text-slate-400">Số tiền</div><div class="mt-2 text-2xl font-black">{{ number_format($lichHen->tong_tien) }}đ</div></div>
                    <div class="rounded-[1.5rem] bg-slate-50 border border-slate-100 p-5"><div class="text-xs font-black uppercase tracking-widest text-slate-400">Return URL</div><div class="mt-2 text-sm font-bold break-all">/vnpay/lich-hen/.../ket-qua</div></div>
                    <div class="rounded-[1.5rem] bg-slate-50 border border-slate-100 p-5"><div class="text-xs font-black uppercase tracking-widest text-slate-400">Trạng thái</div><div class="mt-2"><x-badge-status :status="$thanhToan->trang_thai ?? 'chua_thanh_toan'" /></div></div>
                </div>

                @if($thanhToan?->vnpay_payment_url)
                    <a href="{{ $thanhToan->vnpay_payment_url }}" target="_blank" class="mt-6 bh-btn-light w-full">Mở lại link VNPAY vừa tạo</a>
                @endif

                <form method="POST" action="{{ route('vnpay.appointment.create', $lichHen) }}" class="mt-6 grid md:grid-cols-[1fr_auto] gap-3">
                    @csrf
                    <select name="bank_code" class="bh-input">
                        <option value="">Để VNPAY tự chọn phương thức</option>
                        <option value="VNPAYQR">VNPAY QR</option>
                        <option value="NCB">Thẻ test NCB</option>
                        <option value="ATM">ATM nội địa</option>
                        <option value="INTCARD">Thẻ quốc tế</option>
                    </select>
                    <button class="bh-btn-dark">Tạo link VNPAY</button>
                </form>

                <div class="mt-5 rounded-[1.5rem] bg-blue-50 border border-blue-100 p-5 text-sm text-blue-800 leading-relaxed">
                    <strong>Ghi chú:</strong> VNPAY Sandbox cần điền VNPAY_TMN_CODE và VNPAY_HASH_SECRET trong file .env. Nếu test online callback/IPN, hãy dùng ngrok và đặt APP_URL bằng URL ngrok.
                </div>
            </section>

            <section x-show="tab === 'momo'" x-cloak class="bh-card p-6 lg:p-8">
                <div class="flex flex-col lg:flex-row gap-6">
                    <div class="lg:w-[320px] rounded-[1.8rem] border border-fuchsia-100 bg-fuchsia-50 p-5">
                        <div class="h-12 w-12 rounded-2xl bg-[#a50064] text-white grid place-items-center font-black">M</div>
                        <h2 class="mt-4 text-2xl font-black">MoMo Demo/QR</h2>
                        <p class="mt-2 text-sm text-slate-500">Dùng QR tĩnh cho đồ án hoặc bật MoMo sandbox khi có key Merchant.</p>
                        <div class="mt-4 bg-white rounded-[1.5rem] p-4 border border-fuchsia-100">
                            <img src="{{ $momoQrImage }}" alt="MoMo QR" class="mx-auto h-56 w-56 rounded-2xl object-contain">
                        </div>
                    </div>
                    <div class="flex-1">
                        <div class="grid md:grid-cols-2 gap-4 text-sm font-bold">
                            <div class="rounded-[1.5rem] bg-slate-50 border border-slate-100 p-5"><span class="text-slate-400">Người nhận</span><div class="mt-1 text-slate-950">{{ $momoReceiver }}</div></div>
                            <div class="rounded-[1.5rem] bg-slate-50 border border-slate-100 p-5"><span class="text-slate-400">Số MoMo</span><div class="mt-1 text-slate-950">{{ $momoPhone }}</div></div>
                            <div class="rounded-[1.5rem] bg-slate-50 border border-slate-100 p-5"><span class="text-slate-400">Số tiền</span><div class="mt-1 text-orange-600 text-xl font-black">{{ number_format($lichHen->tong_tien) }}đ</div></div>
                            <div class="rounded-[1.5rem] bg-slate-50 border border-slate-100 p-5"><span class="text-slate-400">Nội dung</span><div class="mt-1 text-slate-950 font-black">{{ $paymentContent }}</div></div>
                        </div>

                        <div class="mt-5 rounded-[1.5rem] bg-slate-950 p-5 text-white">
                            <div class="flex justify-between gap-3 text-sm"><span class="text-slate-400">MoMo Sandbox API</span><strong class="{{ $momoConfigured ? 'text-emerald-400' : 'text-amber-400' }}">{{ $momoConfigured ? 'Đã cấu hình' : 'Chưa cấu hình' }}</strong></div>
                            @if($thanhToan?->momo_pay_url)
                                <a href="{{ $thanhToan->momo_pay_url }}" target="_blank" class="mt-4 bh-btn-light w-full text-center">Mở lại link MoMo</a>
                            @endif
                        </div>

                        <form method="POST" action="{{ route('momo.appointment.create', $lichHen) }}" class="mt-5">
                            @csrf
                            <button class="w-full rounded-2xl bg-[#a50064] px-5 py-4 text-white font-black hover:bg-slate-950 transition">{{ $momoConfigured ? 'Thanh toán qua MoMo Sandbox' : 'Chọn MoMo QR Demo' }}</button>
                        </form>
                    </div>
                </div>
            </section>

            <section x-show="tab === 'manual'" x-cloak class="bh-dark-card p-6 lg:p-8">
                <p class="text-xs font-black uppercase tracking-[.25em] text-orange-400">Manual Confirm</p>
                <h2 class="mt-2 text-3xl font-black tracking-[-.04em]">Gửi thông tin thanh toán cho admin</h2>
                <p class="mt-3 text-slate-400">Dùng khi bạn chuyển khoản ngân hàng, quét MoMo QR tĩnh hoặc cần admin kiểm tra mã giao dịch.</p>

                <form method="POST" action="{{ route('public.thanh-toan.confirm', $lichHen) }}" class="mt-6 space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-black mb-2">Phương thức</label>
                        <select name="phuong_thuc" class="w-full rounded-2xl border-white/10 bg-white/10 px-4 py-3 text-sm font-bold text-white focus:border-orange-400 focus:ring-orange-400/20" required>
                            <option class="text-slate-900" value="tien_mat" @selected(($thanhToan->phuong_thuc ?? '') === 'tien_mat')>Tiền mặt tại cửa hàng</option>
                            <option class="text-slate-900" value="chuyen_khoan" @selected(($thanhToan->phuong_thuc ?? '') === 'chuyen_khoan')>Chuyển khoản ngân hàng</option>
                            <option class="text-slate-900" value="momo" @selected(($thanhToan->phuong_thuc ?? '') === 'momo')>MoMo QR Demo</option>
                            <option class="text-slate-900" value="vnpay" @selected(($thanhToan->phuong_thuc ?? '') === 'vnpay')>VNPAY Sandbox</option>
                            <option class="text-slate-900" value="vi_dien_tu" @selected(($thanhToan->phuong_thuc ?? '') === 'vi_dien_tu')>Ví điện tử khác</option>
                        </select>
                    </div>
                    <div class="rounded-[1.5rem] bg-white/10 p-4 text-sm">
                        <p class="text-slate-300">Nội dung thanh toán bắt buộc</p>
                        <p class="mt-2"><strong>Số tiền:</strong> {{ number_format($lichHen->tong_tien) }}đ</p>
                        <p><strong>Nội dung:</strong> {{ $paymentContent }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-black mb-2">Ghi chú / mã giao dịch</label>
                        <textarea name="ghi_chu" rows="4" class="w-full rounded-2xl border-white/10 bg-white/10 px-4 py-3 text-sm font-bold text-white placeholder:text-slate-500 focus:border-orange-400 focus:ring-orange-400/20" placeholder="Ví dụ: Đã chuyển VNPAY/MoMo, mã GD 123456...">{{ old('ghi_chu', $thanhToan->ghi_chu ?? '') }}</textarea>
                    </div>
                    <button class="w-full rounded-2xl bg-orange-500 px-5 py-4 text-white font-black hover:bg-white hover:text-slate-950 transition">Gửi thông tin thanh toán</button>
                </form>
            </section>
        </div>
    </div>
</section>
@endsection
