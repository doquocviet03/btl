@extends('admin.layouts.app')

@section('title', 'Thông báo')
@section('page_title', 'Thông báo')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
    <h1 class="text-2xl font-bold mb-4">Thông báo</h1>

    <p class="text-slate-500">
        Trang này dùng để hiển thị danh sách thông báo admin. Hiện tại route chính đang dùng API:
        <code>/admin/thong-bao/latest</code>.
    </p>
</div>
@endsection