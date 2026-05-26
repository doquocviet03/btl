<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Barber House')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .hero-bg{background:radial-gradient(circle at 15% 20%,rgba(249,115,22,.24),transparent 28%),radial-gradient(circle at 85% 10%,rgba(15,23,42,.12),transparent 30%),linear-gradient(135deg,#fff7ed 0%,#f8fafc 46%,#e2e8f0 100%)}
        .glass{background:rgba(255,255,255,.78);backdrop-filter:blur(18px);border:1px solid rgba(226,232,240,.9);box-shadow:0 22px 60px rgba(15,23,42,.08)}
        .dark-glass{background:rgba(15,23,42,.92);border:1px solid rgba(255,255,255,.08);box-shadow:0 22px 60px rgba(15,23,42,.22)}
        .section-title{font-size:clamp(2rem,4vw,4.5rem);line-height:.95;font-weight:950;letter-spacing:-.06em}
        .soft-input{border-radius:1rem;border-color:#e2e8f0;background:#fff}
        .soft-input:focus{border-color:#f97316;box-shadow:0 0 0 3px rgba(249,115,22,.14)}
    </style>
    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-900 antialiased">
    <div class="min-h-screen flex flex-col">
        @include('user.layouts.header')
        <main class="flex-1">
            @include('components.alert')
            @yield('content')
        </main>
        @include('user.layouts.footer')
    </div>
    @stack('scripts')
</body>
</html>
