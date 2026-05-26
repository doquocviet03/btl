@extends('admin.layouts.app')
@section('title', 'Quản lý đơn hàng')
@section('page_title', 'Quản lý đơn hàng')
@section('content')
<div class="bh-card p-6">
    <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4 mb-6">
        <div>
            <p class="bh-eyebrow">Orders</p>
            <h1 class="text-3xl font-black tracking-tight mt-2">Đơn hàng sản phẩm</h1>
            <p class="text-slate-500 mt-1">Theo dõi đơn hàng từ trang giỏ hàng user.</p>
        </div>
    </div>

    <form method="GET" class="grid md:grid-cols-4 gap-3 mb-6">
        <input name="q" value="{{ request('q') }}" class="bh-input md:col-span-2" placeholder="Mã đơn, khách hàng, số điện thoại...">
        <select name="trang_thai" class="bh-input">
            <option value="">Tất cả trạng thái</option>
            <option value="cho_xac_nhan" @selected(request('trang_thai')==='cho_xac_nhan')>Chờ xác nhận</option>
            <option value="dang_chuan_bi" @selected(request('trang_thai')==='dang_chuan_bi')>Đang chuẩn bị</option>
            <option value="dang_giao" @selected(request('trang_thai')==='dang_giao')>Đang giao</option>
            <option value="hoan_thanh" @selected(request('trang_thai')==='hoan_thanh')>Hoàn thành</option>
            <option value="da_huy" @selected(request('trang_thai')==='da_huy')>Đã hủy</option>
        </select>
        <button class="bh-btn-dark">Lọc</button>
    </form>

    <div class="bh-table-wrap">
        <table class="bh-table">
            <thead><tr><th>Mã đơn</th><th>Khách hàng</th><th>Tổng tiền</th><th>Sản phẩm</th><th>Thanh toán</th><th>Trạng thái</th><th class="text-right">Thao tác</th></tr></thead>
            <tbody>
            @forelse($donHang as $item)
                <tr>
                    <td class="font-black">{{ $item->ma_don_hang }}</td>
                    <td><div class="font-black">{{ $item->ho_ten }}</div><div class="text-xs text-slate-500 mt-1">{{ $item->so_dien_thoai }}</div></td>
                    <td class="font-black text-orange-500">{{ number_format($item->tong_tien) }}đ</td>
                    <td>{{ $item->chi_tiet_count }} món</td>
                    <td>{{ ['cod'=>'COD','chuyen_khoan'=>'Chuyển khoản','momo'=>'MoMo QR','vnpay'=>'VNPAY'][$item->phuong_thuc_thanh_toan] ?? $item->phuong_thuc_thanh_toan }}<div class="mt-1"><x-badge-status :status="$item->trang_thai_thanh_toan ?? 'chua_thanh_toan'" /></div></td>
                    <td><x-badge-status :status="$item->trang_thai" /></td>
                    <td><div class="flex justify-end gap-2"><a href="{{ route('admin.don-hang.edit', $item) }}" class="bh-btn-light !px-3 !py-2">Xử lý</a><form method="POST" action="{{ route('admin.don-hang.destroy', $item) }}" onsubmit="return confirm('Xóa đơn hàng này?')">@csrf @method('DELETE')<button class="rounded-2xl bg-red-50 px-4 py-2 text-sm font-black text-red-600">Xóa</button></form></div></td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center text-slate-500 py-10">Chưa có đơn hàng.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $donHang->links() }}</div>
</div>
@endsection
