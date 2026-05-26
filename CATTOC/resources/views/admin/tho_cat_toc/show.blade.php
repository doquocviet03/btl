@extends('admin.layouts.app')
@section('title', 'Trang đang hoàn thiện')
@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
    <h1 class="text-2xl font-bold">Trang đang hoàn thiện</h1>
    <p class="text-slate-500 mt-1">Chức năng này chưa được kích hoạt trong route hiện tại.</p>
    <a href="{{ url()->previous() }}" class="inline-block mt-4 px-4 py-2 rounded-xl border">Quay lại</a>
</div>
@endsection
