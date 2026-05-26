@extends('admin.layouts.app')

@section('title', 'Quản lý dịch vụ')
@section('page_title', 'Quản lý dịch vụ')

@section('content')

<div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                Quản lý dịch vụ
            </h1>

            <p class="text-slate-500 mt-1">
                Quản lý danh sách dịch vụ cắt tóc.
            </p>
        </div>

        <a href="{{ route('admin.dich-vu.create') }}"
           class="px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl transition">
            + Thêm dịch vụ
        </a>
    </div>

    {{-- Search --}}
    <form method="GET" class="mb-6">
        <div class="flex gap-3">
            <input
                type="text"
                name="q"
                value="{{ request('q') }}"
                placeholder="Tìm kiếm dịch vụ..."
                class="w-full md:w-96 rounded-xl border-slate-300 focus:border-slate-500 focus:ring-slate-500"
            >

            <button
                type="submit"
                class="px-4 py-2 bg-slate-800 text-white rounded-xl hover:bg-slate-700">
                Tìm
            </button>
        </div>
    </form>

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-100 text-slate-700">
                    <th class="p-3 text-left">ID</th>
                    <th class="p-3 text-left">Tên dịch vụ</th>
                    <th class="p-3 text-left">Danh mục</th>
                    <th class="p-3 text-left">Giá</th>
                    <th class="p-3 text-left">Thời gian</th>
                    <th class="p-3 text-left">Trạng thái</th>
                    <th class="p-3 text-right">Thao tác</th>
                </tr>
            </thead>

            <tbody>

                @forelse($dichVu as $item)

                    <tr class="border-t hover:bg-slate-50">

                        <td class="p-3">
                            {{ $item->id }}
                        </td>

                        <td class="p-3 font-medium text-slate-800">
                            {{ $item->ten_dich_vu }}
                        </td>

                        <td class="p-3">
                            {{ $item->danhMuc->ten_danh_muc ?? '-' }}
                        </td>

                        <td class="p-3">
                            {{ number_format($item->gia) }}đ
                        </td>

                        <td class="p-3">
                            {{ $item->thoi_gian }} phút
                        </td>

                        <td class="p-3">
                            @if($item->trang_thai)

                                <span class="px-3 py-1 rounded-full text-xs bg-green-100 text-green-700">
                                    Hiển thị
                                </span>

                            @else

                                <span class="px-3 py-1 rounded-full text-xs bg-red-100 text-red-700">
                                    Ẩn
                                </span>

                            @endif
                        </td>

                        <td class="p-3">
                            <div class="flex justify-end gap-2">

                                <a href="{{ route('admin.dich-vu.edit', $item->id) }}"
                                   class="px-3 py-1 rounded-lg bg-blue-100 text-blue-700 hover:bg-blue-200 transition">
                                    Sửa
                                </a>

                                <form
                                    action="{{ route('admin.dich-vu.destroy', $item->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Bạn có chắc muốn xóa dịch vụ này?')"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="px-3 py-1 rounded-lg bg-red-100 text-red-700 hover:bg-red-200 transition">
                                        Xóa
                                    </button>
                                </form>

                            </div>
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="7" class="p-6 text-center text-slate-500">
                            Chưa có dịch vụ nào.
                        </td>
                    </tr>

                @endforelse

            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $dichVu->links() }}
    </div>

</div>

@endsection