<header class="sticky top-0 z-40 border-b border-slate-200/80 bg-white/85 backdrop-blur-2xl">
    {{-- UI NOTE: Topbar admin. page_title lấy từ @section('page_title') ở từng view. --}}
    <div class="h-20 px-4 md:px-6 lg:px-8 flex items-center justify-between gap-4">
        <div>
            <p class="text-xs font-black uppercase tracking-[.24em] text-orange-500">Admin Panel</p>
            <h2 class="text-2xl font-black tracking-[-.04em]">@yield('page_title', 'Quản trị hệ thống')</h2>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('public.home') }}" class="hidden sm:inline-flex bh-btn-light !py-2.5">Website</a>
            <div class="hidden md:block text-right">
                <div class="text-sm font-black">{{ auth()->user()->ho_ten ?? 'Admin' }}</div>
                <div class="text-xs text-slate-500">{{ auth()->user()->email ?? '' }}</div>
            </div>
            <div class="h-11 w-11 rounded-2xl bg-slate-950 text-orange-400 grid place-items-center font-black">{{ mb_substr(auth()->user()->ho_ten ?? 'A',0,1) }}</div>
        </div>
    </div>
</header>
