@extends('admin.layouts.app')
@section('title', 'Sửa sản phẩm')
@section('content')
<div class="bh-card p-6 max-w-5xl"><h1 class="text-3xl font-black tracking-tight mb-6">Sửa sản phẩm</h1><form method="POST" action="{{ route('admin.san-pham.update', $sanPham) }}" class="space-y-6">@csrf @method('PUT') @include('admin.san_pham.form')<div class="flex gap-3"><button class="bh-btn-primary">Cập nhật</button><a href="{{ route('admin.san-pham.index') }}" class="bh-btn-light">Quay lại</a></div></form></div>
@endsection
