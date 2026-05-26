@extends('admin.layouts.app')
@section('title', 'Quản lý sản phẩm')
@section('page_title', 'Quản lý sản phẩm')
@section('content')
<div class="bh-card p-6">
    {{-- UI NOTE: Trang quản lý sản phẩm. Sửa cột bảng tại tbody, sửa filter tại form bên dưới. --}}
    <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4 mb-6">
        <div>
            <p class="bh-eyebrow">Shop Admin</p>
            <h1 class="text-3xl font-black tracking-tight mt-2">Sản phẩm chăm sóc tóc</h1>
            <p class="text-slate-500 mt-1">Quản lý sản phẩm bán trên trang user.</p>
        </div>
        <a href="{{ route('admin.san-pham.create') }}" class="bh-btn-primary">Thêm sản phẩm</a>
    </div>

    <form method="GET" class="grid md:grid-cols-4 gap-3 mb-6">
        <input name="q" value="{{ request('q') }}" class="bh-input md:col-span-2" placeholder="Tìm sản phẩm...">
        <select name="loai_san_pham" class="bh-input">
            <option value="">Tất cả loại</option>
            <option value="cham_soc_toc" @selected(request('loai_san_pham')==='cham_soc_toc')>Chăm sóc tóc</option>
            <option value="cham_soc_da_dau" @selected(request('loai_san_pham')==='cham_soc_da_dau')>Chăm sóc da đầu</option>
            <option value="tao_kieu" @selected(request('loai_san_pham')==='tao_kieu')>Tạo kiểu</option>
            <option value="combo" @selected(request('loai_san_pham')==='combo')>Combo</option>
        </select>
        <button class="bh-btn-dark">Lọc</button>
    </form>

    <div class="bh-table-wrap">
        <table class="bh-table">
            <thead><tr><th>Sản phẩm</th><th>Loại</th><th>Giá</th><th>Tồn kho</th><th>Trạng thái</th><th class="text-right">Thao tác</th></tr></thead>
            <tbody>
            @forelse($sanPham as $item)
                <tr>
                    <td><div class="font-black">{{ $item->ten_san_pham }}</div><div class="text-xs text-slate-500 mt-1">{{ $item->thuong_hieu ?? 'Barber House' }}</div></td>
                    <td>{{ ['cham_soc_toc'=>'Chăm sóc tóc','cham_soc_da_dau'=>'Chăm sóc da đầu','tao_kieu'=>'Tạo kiểu','combo'=>'Combo'][$item->loai_san_pham] ?? $item->loai_san_pham }}</td>
                    <td><div class="font-black text-orange-500">{{ number_format($item->gia_ban) }}đ</div>@if($item->gia_khuyen_mai)<div class="text-xs line-through text-slate-400">{{ number_format($item->gia) }}đ</div>@endif</td>
                    <td>{{ $item->so_luong_ton }}</td>
                    <td><x-badge-status :status="$item->trang_thai ? 'hoat_dong' : 'tam_khoa'" /></td>
                    <td><div class="flex justify-end gap-2"><a href="{{ route('admin.san-pham.edit', $item) }}" class="bh-btn-light !px-3 !py-2">Sửa</a><form method="POST" action="{{ route('admin.san-pham.destroy', $item) }}" onsubmit="return confirm('Xóa sản phẩm này?')">@csrf @method('DELETE')<button class="rounded-2xl bg-red-50 px-4 py-2 text-sm font-black text-red-600">Xóa</button></form></div></td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-slate-500 py-10">Chưa có sản phẩm.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $sanPham->links() }}</div>
</div>
@endsection
