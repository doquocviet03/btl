<x-guest-layout>
    <div class="bh-site-shell min-h-screen grid lg:grid-cols-2">
        <div class="relative hidden overflow-hidden p-12 lg:flex lg:flex-col lg:justify-between">
            <div class="jelly-wrap">
                <div class="jelly-core"></div>
                <span class="jelly-tentacle"></span>
                <span class="jelly-tentacle"></span>
                <span class="jelly-tentacle"></span>
            </div>
            <a href="{{ route('public.home') }}" class="relative z-10 flex items-center gap-3">
                <span class="relative grid h-12 w-12 place-items-center overflow-hidden rounded-2xl font-black text-white"><span class="absolute inset-0 bg-gradient-to-br from-red-500 via-fuchsia-500 to-orange-400"></span><span class="relative">BH</span></span>
                <span class="text-2xl font-black tracking-[-.05em] text-white">Barber House</span>
            </a>
            <div class="relative z-10 max-w-xl">
                <p class="bh-eyebrow">Customer Login</p>
                <h1 class="mt-5 text-7xl font-black leading-[.85] tracking-[-.09em] text-white">Đăng nhập khách hàng.</h1>
                <p class="mt-6 leading-relaxed text-zinc-400">Theo dõi lịch hẹn, thanh toán, đánh giá dịch vụ và mua sản phẩm chăm sóc tóc trong một tài khoản duy nhất.</p>
            </div>
            <div class="relative z-10 grid grid-cols-3 gap-3 text-sm font-bold text-white">
                <div class="rounded-3xl border border-white/10 bg-white/10 p-4"><strong class="block text-2xl">24/7</strong><span class="text-zinc-400">Đặt lịch</span></div>
                <div class="rounded-3xl border border-white/10 bg-white/10 p-4"><strong class="block text-2xl">Care</strong><span class="text-zinc-400">Sản phẩm</span></div>
                <div class="rounded-3xl border border-white/10 bg-white/10 p-4"><strong class="block text-2xl">Fast</strong><span class="text-zinc-400">Theo dõi</span></div>
            </div>
        </div>

        <div class="flex items-center justify-center p-6">
            <div class="w-full max-w-md bh-card p-8">
                <a href="{{ route('public.home') }}" class="mb-8 flex items-center gap-3 lg:hidden"><span class="grid h-11 w-11 place-items-center rounded-2xl bg-gradient-to-br from-red-500 to-orange-500 font-black text-white">BH</span><span class="text-xl font-black text-white">Barber House</span></a>
                <p class="bh-eyebrow">Sign in</p>
                <h2 class="mt-4 text-4xl font-black tracking-[-.06em] text-white">Đăng nhập user</h2>
                <p class="mt-2 font-bold text-zinc-500">Dành cho khách hàng đặt lịch và mua sản phẩm.</p>
                <x-auth-session-status class="mt-5" :status="session('status')" />
                <form method="POST" action="{{ route('login') }}" class="mt-7 space-y-5">
                    @csrf
                    <div><label class="bh-label">Email</label><input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="bh-input"><x-input-error :messages="$errors->get('email')" class="mt-2" /></div>
                    <div><label class="bh-label">Mật khẩu</label><input id="password" type="password" name="password" required autocomplete="current-password" class="bh-input"><x-input-error :messages="$errors->get('password')" class="mt-2" /></div>
                    <div class="flex items-center justify-between gap-3"><label class="inline-flex items-center gap-2 text-sm font-bold text-zinc-400"><input type="checkbox" name="remember" class="rounded border-white/20 bg-black text-red-500 focus:ring-red-500"> Ghi nhớ</label>@if (Route::has('password.request'))<a href="{{ route('password.request') }}" class="text-sm font-black text-orange-400 hover:text-white">Quên mật khẩu?</a>@endif</div>
                    <button class="bh-btn-primary w-full">Đăng nhập</button>
                    <p class="text-center text-sm font-bold text-zinc-500">Chưa có tài khoản? <a href="{{ route('register') }}" class="font-black text-orange-400 hover:text-white">Đăng ký user</a></p>
                </form>
                <div class="mt-6 rounded-2xl border border-white/10 bg-white/[.06] p-4 text-sm font-bold text-zinc-300"><p><strong class="text-white">Khách mẫu:</strong> khachhang@barber.test / 12345678</p><p class="mt-1 text-zinc-500">Admin đăng nhập cùng form, sau đó tự chuyển về dashboard.</p></div>
            </div>
        </div>
    </div>
</x-guest-layout>
