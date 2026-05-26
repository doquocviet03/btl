<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', 'Barber House - đặt lịch cắt tóc nam, chọn barber, thanh toán online và mua sản phẩm chăm sóc tóc chính hãng.')">
    <title>@yield('title', 'Barber House')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="antialiased">
    <div class="bh-noise"></div>
    <div class="bh-site-shell min-h-screen flex flex-col">
        @include('user.layouts.header')
        <main class="flex-1">
            <div class="bh-container pt-4">
                @include('components.alert')
            </div>
            @yield('content')
        </main>
        @include('user.layouts.footer')
    </div>
    @stack('scripts')
</body>
</html>
