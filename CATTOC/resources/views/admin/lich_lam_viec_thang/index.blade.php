@extends('admin.layouts.app')

@section('title', 'Lịch làm việc thợ')
@section('page_title', 'Lịch làm việc thợ')

@section('content')
@php
    // UI NOTE: Trang này đã đồng bộ theo hệ thống .bh-* trong resources/css/app.css.
    // Muốn đổi màu/card/button toàn trang, sửa class .bh-card, .bh-btn-primary, .bh-input trong app.css.
    $tongTho = $thoCatToc->count();
    $dangLam = $thoCatToc->filter(function ($tho) use ($lichLamViec) {
        $lich = $lichLamViec[$tho->id] ?? null;
        return $lich && (int) $lich->trang_thai === 1;
    })->count();
    $dangNghi = max($tongTho - $dangLam, 0);
    $caLabels = [
        'ca_ngay' => 'Làm cả ngày',
        'sang' => 'Ca sáng',
        'chieu' => 'Ca chiều',
        'nghi' => 'Nghỉ',
    ];
    $caTimes = [
        'ca_ngay' => '08:00 - 18:00',
        'sang' => '08:00 - 12:00',
        'chieu' => '13:00 - 18:00',
        'nghi' => 'Không nhận lịch',
    ];
@endphp

<div class="space-y-6">
    <div class="grid xl:grid-cols-[1fr_.38fr] gap-6">
        <section class="bh-card p-6 lg:p-8 overflow-hidden relative">
            <div class="absolute -right-20 -top-24 h-64 w-64 rounded-full bg-orange-500/10 blur-3xl"></div>
            <div class="relative flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6">
                <div>
                    <p class="bh-eyebrow">Work Schedule</p>
                    <h1 class="mt-2 text-3xl lg:text-4xl font-black tracking-[-0.045em] text-slate-950">Lịch làm việc thợ</h1>
                    <p class="mt-3 max-w-2xl text-slate-500 leading-relaxed">
                        Quản lý ca làm theo từng ngày. User chỉ đặt được lịch khi thợ đang có ca làm và không bị trùng giờ.
                    </p>
                </div>

                <div class="grid grid-cols-3 gap-3 min-w-[360px]">
                    <div class="rounded-[1.4rem] bg-slate-950 p-4 text-white">
                        <div class="text-xs font-black uppercase tracking-widest text-slate-400">Tổng thợ</div>
                        <div class="mt-2 text-3xl font-black">{{ $tongTho }}</div>
                    </div>
                    <div class="rounded-[1.4rem] bg-emerald-50 p-4 text-emerald-700 border border-emerald-100">
                        <div class="text-xs font-black uppercase tracking-widest">Đang làm</div>
                        <div class="mt-2 text-3xl font-black">{{ $dangLam }}</div>
                    </div>
                    <div class="rounded-[1.4rem] bg-orange-50 p-4 text-orange-700 border border-orange-100">
                        <div class="text-xs font-black uppercase tracking-widest">Nghỉ</div>
                        <div class="mt-2 text-3xl font-black">{{ $dangNghi }}</div>
                    </div>
                </div>
            </div>
        </section>

        <aside class="bh-dark-card p-6 lg:p-8">
            <p class="text-xs font-black uppercase tracking-[.25em] text-orange-400">Ngày đang chọn</p>
            <div class="mt-4 text-5xl font-black tracking-[-.08em]">{{ $date->format('d') }}</div>
            <div class="mt-1 text-xl font-black text-white/90">Tháng {{ $date->format('m/Y') }}</div>
            <div class="mt-4 inline-flex rounded-full bg-white/10 px-4 py-2 text-sm font-black text-white/80">
                {{ $date->translatedFormat('l') }}
            </div>
        </aside>
    </div>

    <section class="bh-card p-5 lg:p-6">
        <form method="GET" class="grid lg:grid-cols-[220px_220px_1fr] gap-4 items-end">
            <div>
                <label class="bh-label">Chọn tháng</label>
                <input type="month" name="month" value="{{ $month }}" onchange="this.form.submit()" class="bh-input">
            </div>
            <div>
                <label class="bh-label">Chọn ngày</label>
                <input type="date" name="date" value="{{ $date->format('Y-m-d') }}" onchange="this.form.submit()" class="bh-input">
            </div>
            <div class="flex flex-wrap gap-3 lg:justify-end">
                <a href="{{ route('admin.lich-lam-viec-thang.index', ['month' => $date->copy()->subDay()->format('Y-m'), 'date' => $date->copy()->subDay()->format('Y-m-d')]) }}" class="bh-btn-light">← Hôm qua</a>
                <a href="{{ route('admin.lich-lam-viec-thang.index', ['month' => now()->format('Y-m'), 'date' => now()->format('Y-m-d')]) }}" class="bh-btn-dark">Hôm nay</a>
                <a href="{{ route('admin.lich-lam-viec-thang.index', ['month' => $date->copy()->addDay()->format('Y-m'), 'date' => $date->copy()->addDay()->format('Y-m-d')]) }}" class="bh-btn-primary">Ngày kế tiếp →</a>
            </div>
        </form>
    </section>

    <form method="POST" action="{{ route('admin.lich-lam-viec-thang.store') }}" class="bh-card p-5 lg:p-6">
        @csrf
        <input type="hidden" name="month" value="{{ $month }}">
        <input type="hidden" name="date" value="{{ $date->format('Y-m-d') }}">

        <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-4 mb-6">
            <div>
                <p class="bh-eyebrow">Daily Shift</p>
                <h2 class="mt-2 text-2xl lg:text-3xl font-black tracking-[-0.04em] text-slate-950">Lịch ngày {{ $date->format('d/m/Y') }}</h2>
                <p class="mt-1 text-slate-500">Chọn ca nhanh cho từng thợ, sau đó bấm lưu lịch làm việc.</p>
            </div>
            <button class="bh-btn-primary">Lưu lịch làm việc</button>
        </div>

        <div class="bh-table-wrap">
            <table class="bh-table">
                <thead>
                    <tr>
                        <th class="w-24">ID</th>
                        <th>Thợ cắt tóc</th>
                        <th class="w-56">Ca làm</th>
                        <th class="w-44">Thời gian</th>
                        <th>Ghi chú</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($thoCatToc as $tho)
                    @php
                        $lich = $lichLamViec[$tho->id] ?? null;
                        $selectedCa = ($lich && (int) $lich->trang_thai === 1) ? $lich->ca_lam : 'nghi';
                    @endphp
                    <tr>
                        <td class="font-black text-slate-400">#{{ $tho->id }}</td>
                        <td>
                            <div class="flex items-center gap-3">
                                <div class="h-11 w-11 rounded-2xl bg-slate-950 text-white grid place-items-center text-sm font-black">
                                    {{ mb_substr($tho->ho_ten, 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-black text-slate-950">{{ $tho->ho_ten }}</div>
                                    <div class="text-xs text-slate-500 mt-1">{{ $tho->chuyen_mon ?? 'Barber stylist' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <select name="lich[{{ $tho->id }}][ca_lam]" class="bh-input">
                                <option value="ca_ngay" @selected($selectedCa === 'ca_ngay')>Làm cả ngày</option>
                                <option value="sang" @selected($selectedCa === 'sang')>Ca sáng</option>
                                <option value="chieu" @selected($selectedCa === 'chieu')>Ca chiều</option>
                                <option value="nghi" @selected($selectedCa === 'nghi')>Nghỉ</option>
                            </select>
                        </td>
                        <td>
                            <span class="bh-chip {{ $selectedCa === 'nghi' ? 'bg-slate-100 text-slate-500' : 'bg-emerald-50 text-emerald-700' }}">
                                {{ $caTimes[$selectedCa] ?? '08:00 - 18:00' }}
                            </span>
                        </td>
                        <td>
                            <input type="text" name="lich[{{ $tho->id }}][ghi_chu]" value="{{ $lich->ghi_chu ?? '' }}" placeholder="Ví dụ: Nghỉ phép, đi muộn, ưu tiên khách quen..." class="bh-input">
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-slate-500 py-12">Chưa có thợ cắt tóc. Hãy thêm thợ trước khi tạo lịch làm việc.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6 grid md:grid-cols-4 gap-3">
            @foreach($caLabels as $key => $label)
                <div class="rounded-[1.4rem] border {{ $key === 'nghi' ? 'border-slate-200 bg-slate-50' : 'border-orange-100 bg-orange-50' }} p-4">
                    <div class="text-sm font-black text-slate-950">{{ $label }}</div>
                    <div class="mt-1 text-sm font-bold {{ $key === 'nghi' ? 'text-slate-500' : 'text-orange-600' }}">{{ $caTimes[$key] }}</div>
                </div>
            @endforeach
        </div>
    </form>
</div>
@endsection
