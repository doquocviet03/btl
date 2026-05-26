@php($title = 'Sửa thợ cắt tóc')
@extends('admin.layouts.app')

@section('title', $title ?? 'Biểu mẫu')
@section('content')
<div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">{{ $title }}</h1>
        <p class="text-slate-500 mt-1">Nhập đầy đủ thông tin bắt buộc.</p>
    </div>

    @if ($errors->any())
        <div class="mb-5 rounded-xl bg-red-50 text-red-700 p-4 text-sm">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.tho-cat-toc.update', $thoCatToc->id) }}" class="space-y-5">
        @method('PUT')
        @include('admin.tho_cat_toc.form')
    </form>
</div>
@endsection
