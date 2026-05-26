@extends('admin.layouts.app')

@section('title', 'Quản lý đánh giá')
@section('page_title', 'Quản lý đánh giá')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
    <div class="flex flex-col md:flex-row md:justify-between md:items-end gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-black">Đánh giá</h1>
            <p class="text-slate-500">Duyệt, ẩn hoặc xóa đánh giá của khách hàng.</p>
        </div>
    </div>

    <form method="GET" class="mb-5 grid md:grid-cols-4 gap-3">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Tìm nội dung đánh giá..." class="md:col-span-2 rounded-xl border-slate-300 focus:border-orange-500 focus:ring-orange-500">
        <select name="trang_thai" class="rounded-xl border-slate-300 focus:border-orange-500 focus:ring-orange-500">
            <option value="">Tất cả trạng thái</option>
            <option value="cho_duyet" @selected(request('trang_thai')==='cho_duyet')>Chờ duyệt</option>
            <option value="da_duyet" @selected(request('trang_thai')==='da_duyet')>Đã duyệt</option>
            <option value="an" @selected(request('trang_thai')==='an')>Ẩn</option>
        </select>
        <button class="rounded-xl bg-slate-900 text-white font-bold hover:bg-orange-500 transition">Lọc</button>
    </form>

    <div class="overflow-x-auto rounded-2xl border border-slate-100">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-900 text-white text-left">
                    <th class="p-4">ID</th>
                    <th class="p-4">Khách hàng</th>
                    <th class="p-4">Thợ</th>
                    <th class="p-4">Số sao</th>
                    <th class="p-4">Nội dung</th>
                    <th class="p-4">Trạng thái</th>
                    <th class="p-4 text-right">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($danhGia as $item)
                    <tr class="border-t border-slate-100 hover:bg-orange-50/50 transition">
                        <td class="p-4 font-bold">{{ $item->id }}</td>
                        <td class="p-4">{{ $item->khachHang->ho_ten ?? '-' }}</td>
                        <td class="p-4">{{ $item->tho->ho_ten ?? '-' }}</td>
                        <td class="p-4 text-yellow-500">{{ str_repeat('★', (int) $item->so_sao) }}</td>
                        <td class="p-4 max-w-xs text-slate-600">{{ $item->noi_dung ?? '-' }}</td>
                        <td class="p-4"><x-badge-status :status="$item->trang_thai" /></td>
                        <td class="p-4">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.danh-gia.edit', $item) }}" class="px-3 py-2 rounded-xl bg-blue-50 text-blue-700 font-bold hover:bg-blue-100">Sửa</a>
                                <form method="POST" action="{{ route('admin.danh-gia.destroy', $item) }}" onsubmit="return confirm('Bạn có chắc muốn xóa đánh giá này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-3 py-2 rounded-xl bg-red-50 text-red-700 font-bold hover:bg-red-100">Xóa</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="p-8 text-center text-slate-500">Chưa có đánh giá nào.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $danhGia->links() }}</div>
</div>
@endsection
