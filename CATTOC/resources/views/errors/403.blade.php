@extends('user.layouts.app')
@section('title', '403 - Không có quyền truy cập')
@section('content')
<section class="hero-bg py-24">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="text-8xl font-black text-orange-500">403</div>
        <h1 class="text-4xl font-black mt-4">Không có quyền truy cập</h1>
        <p class="text-slate-600 mt-3">Bạn không có quyền thực hiện thao tác này.</p>
        <a href="{{ route('public.home') }}" class="inline-flex mt-8 px-6 py-4 rounded-2xl bg-slate-950 text-white font-black hover:bg-orange-500 transition">Về trang chủ</a>
    </div>
</section>
@endsection
