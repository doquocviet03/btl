@extends('admin.layouts.app')

@section('title', 'Quản lý thợ cắt tóc')
@section('page_title', 'Quản lý thợ cắt tóc')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold">Thợ cắt tóc</h1>
            <p class="text-slate-500">Danh sách thợ trong hệ thống.</p>
        </div>

        <a href="{{ route('admin.tho-cat-toc.create') }}"
           class="px-4 py-2 bg-slate-900 text-white rounded-xl">
            Thêm thợ
        </a>
    </div>

    <form method="GET" class="mb-4">
        <input type="text" name="q" value="{{ request('q') }}"
               placeholder="Tìm thợ cắt tóc..."
               class="w-full md:w-96 rounded-xl border-slate-300">
    </form>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 text-left">
                    <th class="p-3">ID</th>
                    <th class="p-3">Họ tên</th>
                    <th class="p-3">SĐT</th>
                    <th class="p-3">Email</th>
                    <th class="p-3">Kinh nghiệm</th>
                    <th class="p-3">Trạng thái</th>
                    <th class="p-3 text-right">Thao tác</th>
                </tr>
            </thead>

            <tbody>
                @forelse($thoCatToc as $item)
                    <tr class="border-t">
                        <td class="p-3">{{ $item->id }}</td>
                        <td class="p-3 font-medium">{{ $item->ho_ten }}</td>
                        <td class="p-3">{{ $item->so_dien_thoai ?? '-' }}</td>
                        <td class="p-3">{{ $item->email ?? '-' }}</td>
                        <td class="p-3">{{ $item->kinh_nghiem ?? 0 }} năm</td>
                        <td class="p-3">
                            <span class="px-3 py-1 rounded-full text-xs {{ $item->trang_thai ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $item->trang_thai ? 'Hoạt động' : 'Tạm nghỉ' }}
                            </span>
                        </td>
                        <td class="p-3">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.tho-cat-toc.edit', $item->id) }}"
                                   class="px-3 py-1 rounded-lg bg-blue-50 text-blue-700">
                                    Sửa
                                </a>

                                <form method="POST" action="{{ route('admin.tho-cat-toc.destroy', $item->id) }}"
                                      onsubmit="return confirm('Bạn có chắc muốn xóa thợ này?')">
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
                        <td colspan="7" class="p-6 text-center text-slate-500">
                            Chưa có thợ cắt tóc nào.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $thoCatToc->links() }}
    </div>
</div>
@endsection