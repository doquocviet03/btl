@php
    // UI NOTE: Menu admin. Đổi label/icon 1 màu tại mảng này. icon đang dùng chữ viết tắt bold để tránh icon rối.
    $groups = [
        'Tổng quan' => [
            ['route' => 'admin.dashboard', 'pattern' => 'admin.dashboard', 'label' => 'Dashboard', 'icon' => 'DB'],
        ],
        'Vận hành' => [
            ['route' => 'admin.lich-hen.index', 'pattern' => 'admin.lich-hen.*', 'label' => 'Lịch hẹn', 'icon' => 'LH'],
            ['route' => 'admin.thanh-toan.index', 'pattern' => 'admin.thanh-toan.*', 'label' => 'Thanh toán', 'icon' => 'TT'],
            ['route' => 'admin.lich-lam-viec-thang.index', 'pattern' => 'admin.lich-lam-viec-thang.*', 'label' => 'Lịch làm việc', 'icon' => 'CA'],
            ['route' => 'admin.danh-gia.index', 'pattern' => 'admin.danh-gia.*', 'label' => 'Đánh giá', 'icon' => 'DG'],
        ],
        'Danh mục' => [
            ['route' => 'admin.khach-hang.index', 'pattern' => 'admin.khach-hang.*', 'label' => 'Khách hàng', 'icon' => 'KH'],
            ['route' => 'admin.tho-cat-toc.index', 'pattern' => 'admin.tho-cat-toc.*', 'label' => 'Thợ cắt tóc', 'icon' => 'TH'],
            ['route' => 'admin.danh-muc-dich-vu.index', 'pattern' => 'admin.danh-muc-dich-vu.*', 'label' => 'Danh mục dịch vụ', 'icon' => 'DM'],
            ['route' => 'admin.dich-vu.index', 'pattern' => 'admin.dich-vu.*', 'label' => 'Dịch vụ', 'icon' => 'DV'],
            ['route' => 'admin.san-pham.index', 'pattern' => 'admin.san-pham.*', 'label' => 'Sản phẩm', 'icon' => 'SP'],
            ['route' => 'admin.don-hang.index', 'pattern' => 'admin.don-hang.*', 'label' => 'Đơn hàng', 'icon' => 'DH'],
            ['route' => 'admin.tai-khoan.index', 'pattern' => 'admin.tai-khoan.*', 'label' => 'Tài khoản', 'icon' => 'TK'],
        ],
    ];
@endphp

<aside class="w-80 bg-[#070a12] text-white min-h-screen hidden lg:flex lg:flex-col border-r border-white/10">
    <div class="p-6 border-b border-white/10">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-[1.4rem] bg-orange-500 grid place-items-center font-black text-xl shadow-lg shadow-orange-500/25">B</div>
            <div>
                <h1 class="text-2xl font-black tracking-[-.05em]">Barber Admin</h1>
                <p class="text-xs text-slate-400 font-bold -mt-1">Operations Dashboard</p>
            </div>
        </a>
    </div>

    <nav class="p-4 space-y-6 flex-1 overflow-y-auto">
        @foreach($groups as $group => $links)
            <div>
                <div class="px-4 mb-2 text-[11px] font-black uppercase tracking-[.24em] text-slate-500">{{ $group }}</div>
                <div class="space-y-1">
                    @foreach($links as $link)
                        @php $active = request()->routeIs($link['pattern']); @endphp
                        <a href="{{ route($link['route']) }}" class="group flex items-center gap-3 px-4 py-3 rounded-2xl transition {{ $active ? 'bg-orange-500 text-white shadow-lg shadow-orange-500/20' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                            <span class="w-10 h-10 rounded-2xl grid place-items-center text-xs font-black {{ $active ? 'bg-white text-orange-500' : 'bg-white/10 text-white group-hover:bg-white group-hover:text-slate-950' }} transition">{{ $link['icon'] }}</span>
                            <span class="font-black text-sm">{{ $link['label'] }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        @endforeach
    </nav>

    <div class="p-4 border-t border-white/10 space-y-3">
        <a href="{{ route('public.home') }}" class="block rounded-2xl bg-white/10 px-4 py-3 text-center text-sm font-black hover:bg-white hover:text-slate-950 transition">Xem website user</a>
        <form method="POST" action="{{ route('logout') }}">@csrf <button class="w-full rounded-2xl border border-white/10 px-4 py-3 text-sm font-black text-slate-300 hover:bg-red-500 hover:text-white transition">Đăng xuất</button></form>
    </div>
</aside>
