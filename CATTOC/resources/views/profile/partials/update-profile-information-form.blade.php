<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            Thông tin tài khoản
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Cập nhật họ tên, số điện thoại và email đăng nhập.
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="ho_ten" value="Họ tên" />
            <x-text-input id="ho_ten" name="ho_ten" type="text" class="mt-1 block w-full" :value="old('ho_ten', $user->ho_ten)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('ho_ten')" />
        </div>

        <div>
            <x-input-label for="so_dien_thoai" value="Số điện thoại" />
            <x-text-input id="so_dien_thoai" name="so_dien_thoai" type="text" class="mt-1 block w-full" :value="old('so_dien_thoai', $user->so_dien_thoai)" autocomplete="tel" />
            <x-input-error class="mt-2" :messages="$errors->get('so_dien_thoai')" />
        </div>

        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>Lưu thay đổi</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >Đã lưu.</p>
            @endif
        </div>
    </form>
</section>
