<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin Dashboard') - Barber House</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- UI NOTE: Layout admin tổng. Sidebar/topbar nằm ở resources/views/admin/layouts. --}}
    @stack('styles')
</head>
<body class="admin-grid-bg bg-slate-100 text-slate-950 antialiased">
    <div class="min-h-screen flex">
        @include('admin.layouts.sidebar')
        <div class="flex-1 flex flex-col min-w-0">
            @include('admin.layouts.topbar')
            <main class="p-4 md:p-6 lg:p-8 flex-1">
                @include('components.alert')
                @yield('content')
            </main>
            @include('admin.layouts.footer')
        </div>
    </div>
    @stack('scripts')
</body>
</html>
