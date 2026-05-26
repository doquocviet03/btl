<x-guest-layout>
    <div class="bh-site-shell flex min-h-screen items-center justify-center p-6">
        <div class="grid w-full max-w-5xl overflow-hidden rounded-[2.4rem] border border-white/10 bg-white/[.06] shadow-[0_36px_110px_rgba(0,0,0,.55)] backdrop-blur-2xl lg:grid-cols-2">
            <div class="relative overflow-hidden p-8 md:p-10">
                <div class="jelly-wrap">
                    <div class="jelly-core"></div>
                    <span class="jelly-tentacle"></span>
                    <span class="jelly-tentacle"></span>
                    <span class="jelly-tentacle"></span>
                </div>
                <div class="relative z-10 flex min-h-full flex-col justify-between gap-10">
                    <a href="{{ route('public.home') }}" class="flex items-center gap-3"><span class="grid h-12 w-12 place-items-center rounded-2xl bg-gradient-to-br from-red-500 to-orange-500 font-black text-white">BH</span><span class="text-2xl font-black tracking-[-.05em] text-white">Barber House</span></a>
                    <div>
                        <p class="bh-eyebrow">Create customer account</p>
                        <h1 class="mt-5 text-6xl font-black leading-[.85] tracking-[-.08em] text-white">Tạo tài khoản khách hàng.</h1>
                        <p class="mt-6 leading-relaxed text-zinc-400">Đăng ký để đặt lịch nhanh hơn, theo dõi lịch, gửi thanh toán, đánh giá dịch vụ và mua sản phẩm.</p>
                    </div>
                    <a href="{{ route('login') }}" class="font-black text-orange-400 hover:text-white">Đã có tài khoản? Đăng nhập →</a>
                </div>
            </div>
            <div class="p-8 md:p-10">
                <p class="bh-eyebrow">Sign up</p>
                <h2 class="mt-4 text-4xl font-black tracking-[-.06em] text-white">Đăng ký user</h2>
                <form method="POST" action="{{ route('register') }}" class="mt-7 space-y-4">
                    @csrf
                    <div><label class="bh-label">Họ tên</label><input id="ho_ten" class="bh-input" type="text" name="ho_ten" value="{{ old('ho_ten') }}" required autofocus autocomplete="name"><x-input-error :messages="$errors->get('ho_ten')" class="mt-2" /></div>
                    <div><label class="bh-label">Số điện thoại</label><input id="so_dien_thoai" class="bh-input" type="text" name="so_dien_thoai" value="{{ old('so_dien_thoai') }}" autocomplete="tel"><x-input-error :messages="$errors->get('so_dien_thoai')" class="mt-2" /></div>
                    <div><label class="bh-label">Email</label><input id="email" class="bh-input" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"><x-input-error :messages="$errors->get('email')" class="mt-2" /></div>
                    <div class="grid gap-4 md:grid-cols-2"><div><label class="bh-label">Mật khẩu</label><input id="password" class="bh-input" type="password" name="password" required autocomplete="new-password"><x-input-error :messages="$errors->get('password')" class="mt-2" /></div><div><label class="bh-label">Nhập lại</label><input id="password_confirmation" class="bh-input" type="password" name="password_confirmation" required autocomplete="new-password"><x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" /></div></div>
                    <button class="bh-btn-primary w-full">Tạo tài khoản user</button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
