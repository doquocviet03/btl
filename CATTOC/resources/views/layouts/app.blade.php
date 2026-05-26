<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Barber House') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900 antialiased">
    @include('user.layouts.header')
    <main class="min-h-screen">
        @isset($header)
            <div class="bg-white border-b border-slate-200"><div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">{{ $header }}</div></div>
        @endisset
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            @include('components.alert')
            {{ $slot }}
        </div>
    </main>
    @include('user.layouts.footer')
</body>
</html>
