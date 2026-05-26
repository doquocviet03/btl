@extends('user.layouts.app')
@section('title', 'Lịch của tôi - Barber House')
@section('content')
<section class="hero-bg py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row md:items-end md:justify-between gap-6">
        <div>
            <p class="text-orange-500 font-black uppercase tracking-widest text-sm">Tài khoản</p>
            <h1 class="section-title mt-3">Lịch của tôi</h1>
        </div>
        <a href="{{ route('public.dat-lich.index') }}" class="px-6 py-4 rounded-2xl bg-orange-500 text-white font-black shadow-xl shadow-orange-500/25 hover:bg-slate-950 transition">Đặt lịch mới</a>
    </div>
</section>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="space-y-5">
        @forelse($lichHen as $item)
            <div class="glass rounded-[2rem] p-6">
                <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-5">
                    <div>
                        <div class="flex flex-wrap items-center gap-2">
                            <h2 class="text-2xl font-black">{{ $item->ma_lich_hen }}</h2>
                            <x-badge-status :status="$item->trang_thai" />
                            @if($item->thanhToan)
                                <x-badge-status :status="$item->thanhToan->trang_thai" />
                            @endif
                        </div>
                        <div class="grid md:grid-cols-3 gap-4 mt-5 text-sm">
                            <div><p class="text-slate-500">Ngày giờ</p><strong>{{ $item->ngay_hen?->format('d/m/Y') }} • {{ $item->gio_bat_dau?->format('H:i') }} - {{ $item->gio_ket_thuc?->format('H:i') }}</strong></div>
                            <div><p class="text-slate-500">Thợ</p><strong>{{ $item->tho->ho_ten ?? '-' }}</strong></div>
                            <div><p class="text-slate-500">Tổng tiền</p><strong class="text-orange-600">{{ number_format($item->tong_tien) }}đ</strong></div>
                        </div>
                        <div class="mt-5 flex flex-wrap gap-2">
                            @foreach($item->chiTiet as $ct)
                                <span class="px-3 py-1 rounded-full bg-white border border-slate-200 text-sm">{{ $ct->ten_dich_vu }}</span>
                            @endforeach
                        </div>
                        @if($item->ly_do_huy)
                            <p class="mt-4 text-sm text-red-600">Lý do hủy: {{ $item->ly_do_huy }}</p>
                        @endif
                    </div>

                    <div class="flex flex-wrap lg:flex-col gap-2 min-w-48">
                        @if($item->thanhToan && $item->thanhToan->trang_thai !== 'da_thanh_toan' && $item->trang_thai !== 'da_huy')
                            <a href="{{ route('public.thanh-toan.index', $item) }}" class="px-4 py-3 rounded-2xl bg-slate-950 text-white text-center font-bold hover:bg-orange-500 transition">Thanh toán</a>
                        @endif

                        @if($item->trang_thai === 'hoan_thanh' && ! $item->danhGia)
                            <a href="{{ route('public.danh-gia.create', $item) }}" class="px-4 py-3 rounded-2xl bg-orange-500 text-white text-center font-bold hover:bg-slate-950 transition">Đánh giá</a>
                        @endif

                        @if(in_array($item->trang_thai, ['cho_xac_nhan', 'da_xac_nhan']))
                            <form method="POST" action="{{ route('public.lich-cua-toi.cancel', $item) }}" onsubmit="return confirm('Bạn chắc chắn muốn hủy lịch này?')">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="ly_do_huy" value="Khách hàng tự hủy lịch">
                                <button class="w-full px-4 py-3 rounded-2xl bg-red-50 text-red-700 font-bold hover:bg-red-100 transition">Hủy lịch</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="glass rounded-[2rem] p-12 text-center">
                <div class="text-6xl">📅</div>
                <h2 class="text-2xl font-black mt-4">Bạn chưa có lịch hẹn</h2>
                <p class="text-slate-500 mt-2">Hãy đặt lịch đầu tiên để trải nghiệm dịch vụ tại Barber House.</p>
                <a href="{{ route('public.dat-lich.index') }}" class="inline-flex mt-6 px-6 py-4 rounded-2xl bg-orange-500 text-white font-black hover:bg-slate-950 transition">Đặt lịch ngay</a>
            </div>
        @endforelse
    </div>
    <div class="mt-8">{{ $lichHen->links() }}</div>
</section>
@endsection
