@extends('admin.layouts.app')
@section('title', 'Quản lý lịch hẹn')
@section('page_title', 'Quản lý lịch hẹn')
@section('content')
<div class="bh-card p-6">
    {{-- UI NOTE: Trang lịch hẹn admin. Cột trạng thái dùng badge-status để không hiện dạng cho_xac_nhan. --}}
    <div class="flex flex-col md:flex-row md:justify-between md:items-end gap-4 mb-6">
        <div>
            <p class="bh-eyebrow">Appointments</p>
            <h1 class="text-3xl font-black tracking-tight mt-2">Danh sách lịch hẹn</h1>
            <p class="text-slate-500 mt-1">Quản lý đặt lịch, thanh toán và hóa đơn.</p>
        </div>
        <a href="{{ route('admin.lich-hen.create') }}" class="bh-btn-primary">Thêm lịch hẹn</a>
    </div>

    <div class="bh-table-wrap">
        <table class="bh-table">
            <thead><tr><th>Mã</th><th>Khách hàng</th><th>Thợ</th><th>Ngày giờ</th><th>Tổng tiền</th><th>Trạng thái</th><th class="text-right">Thao tác</th></tr></thead>
            <tbody>
            @forelse($lichHen as $item)
                <tr>
                    <td class="font-black">{{ $item->ma_lich_hen }}</td>
                    <td>{{ $item->khachHang->ho_ten ?? '-' }}</td>
                    <td>{{ $item->thoCatToc->ho_ten ?? '-' }}</td>
                    <td><div class="font-bold">{{ $item->ngay_hen?->format('d/m/Y') }}</div><div class="text-xs text-slate-500 mt-1">{{ $item->gio_bat_dau }} - {{ $item->gio_ket_thuc }}</div></td>
                    <td class="font-black text-orange-500">{{ number_format($item->tong_tien) }}đ</td>
                    <td><x-badge-status :status="$item->trang_thai" /></td>
                    <td>
                        <div class="flex justify-end gap-2 flex-wrap">
                            <a href="{{ route('admin.lich-hen.edit', $item->id) }}" class="bh-btn-light !px-3 !py-2">Sửa</a>
                            <a href="{{ route('admin.thanh-toan.invoice', $item->id) }}" class="rounded-2xl bg-emerald-50 px-4 py-2 text-sm font-black text-emerald-700 hover:bg-emerald-100">Hóa đơn</a>
                            <form method="POST" action="{{ route('admin.thanh-toan.create-for-appointment', $item->id) }}">@csrf <button class="rounded-2xl bg-orange-50 px-4 py-2 text-sm font-black text-orange-700 hover:bg-orange-100">Thanh toán</button></form>
                            <form action="{{ route('admin.lich-hen.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Xóa lịch hẹn này?')">@csrf @method('DELETE')<button class="rounded-2xl bg-red-50 px-4 py-2 text-sm font-black text-red-600 hover:bg-red-100">Xóa</button></form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center text-slate-500 py-10">Chưa có lịch hẹn.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $lichHen->links() }}</div>
</div>
@endsection
