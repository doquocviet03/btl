@extends('admin.layouts.app')
@section('title', 'Quản lý tài khoản')
@section('page_title', 'Quản lý tài khoản')
@section('content')
<div class="bh-card p-6">
    <div class="flex flex-col md:flex-row md:justify-between md:items-end gap-4 mb-6"><div><p class="bh-eyebrow">Accounts</p><h1 class="text-3xl font-black tracking-tight mt-2">Tài khoản</h1><p class="text-slate-500 mt-1">Quản lý tài khoản admin, khách hàng và thợ.</p></div><a href="{{ route('admin.tai-khoan.create') }}" class="bh-btn-primary">Thêm tài khoản</a></div>
    <form method="GET" class="mb-6"><input type="text" name="q" value="{{ request('q') }}" placeholder="Tìm tài khoản..." class="bh-input max-w-lg"></form>
    <div class="bh-table-wrap"><table class="bh-table"><thead><tr><th>ID</th><th>Họ tên</th><th>Email</th><th>SĐT</th><th>Vai trò</th><th>Trạng thái</th><th class="text-right">Thao tác</th></tr></thead><tbody>
    @forelse($taiKhoan as $item)
        <tr><td class="font-black">{{ $item->id }}</td><td class="font-black">{{ $item->ho_ten }}</td><td>{{ $item->email }}</td><td>{{ $item->so_dien_thoai ?? '-' }}</td><td><x-badge-status :status="$item->vai_tro" /></td><td><x-badge-status :status="$item->trang_thai ? 'hoat_dong' : 'tam_khoa'" /></td><td><div class="flex justify-end gap-2"><a href="{{ route('admin.tai-khoan.edit', $item->id) }}" class="bh-btn-light !px-3 !py-2">Sửa</a><form method="POST" action="{{ route('admin.tai-khoan.destroy', $item->id) }}" onsubmit="return confirm('Bạn có chắc muốn xóa tài khoản này?')">@csrf @method('DELETE')<button class="rounded-2xl bg-red-50 px-4 py-2 text-sm font-black text-red-600">Xóa</button></form></div></td></tr>
    @empty
        <tr><td colspan="7" class="text-center text-slate-500 py-10">Chưa có tài khoản nào.</td></tr>
    @endforelse
    </tbody></table></div><div class="mt-6">{{ $taiKhoan->links() }}</div>
</div>
@endsection
