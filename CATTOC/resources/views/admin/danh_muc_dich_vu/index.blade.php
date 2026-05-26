@extends('admin.layouts.app')

@section('title', 'Danh mục dịch vụ')
@section('page_title', 'Danh mục dịch vụ')

@section('content')

<div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">

    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold">
                Danh mục dịch vụ
            </h1>

            <p class="text-slate-500">
                Quản lý danh mục dịch vụ.
            </p>
        </div>

        <a href="{{ route('admin.danh-muc-dich-vu.create') }}"
           class="px-4 py-2 bg-slate-900 text-white rounded-xl">
            Thêm danh mục
        </a>
    </div>

    <form method="GET" class="mb-4">
        <input
            type="text"
            name="q"
            value="{{ request('q') }}"
            placeholder="Tìm danh mục..."
            class="w-full md:w-96 rounded-xl border-slate-300"
        >
    </form>

    <div class="overflow-x-auto">

        <table class="w-full text-sm">

            <thead>
                <tr class="bg-slate-50 text-left">
                    <th class="p-3">ID</th>
                    <th class="p-3">Tên danh mục</th>
                    <th class="p-3">Mô tả</th>
                    <th class="p-3">Trạng thái</th>
                    <th class="p-3 text-right">Thao tác</th>
                </tr>
            </thead>

            <tbody>

                @forelse($danhMuc as $item)

                    <tr class="border-t">

                        <td class="p-3">
                            {{ $item->id }}
                        </td>

                        <td class="p-3 font-medium">
                            {{ $item->ten_danh_muc }}
                        </td>

                        <td class="p-3">
                            {{ $item->mo_ta ?? '-' }}
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

                                <a href="{{ route('admin.danh-muc-dich-vu.edit', $item->id) }}"
                                   class="px-3 py-1 rounded-lg bg-blue-50 text-blue-700">
                                    Sửa
                                </a>

                                <form
                                    method="POST"
                                    action="{{ route('admin.danh-muc-dich-vu.destroy', $item->id) }}"
                                    onsubmit="return confirm('Bạn có chắc muốn xóa danh mục này?')"
                                >

                                    @csrf
                                    @method('DELETE')

                                    <button class="px-3 py-1 rounded-lg bg-red-50 text-red-700">
                                        Xóa
                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="5" class="p-6 text-center text-slate-500">
                            Chưa có danh mục nào.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <div class="mt-6">
        {{ $danhMuc->links() }}
    </div>

</div>

@endsection