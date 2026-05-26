@extends('admin.layouts.app')
@section('title', 'Quản lý thanh toán')
@section('page_title', 'Quản lý thanh toán')
@section('content')
<div class="bh-card p-6">
    <div class="flex flex-col md:flex-row md:justify-between md:items-end gap-4 mb-6">
        <div><p class="bh-eyebrow">Payments</p><h1 class="text-3xl font-black tracking-tight mt-2">Danh sách thanh toán</h1><p class="text-slate-500 mt-1">Xác nhận thanh toán lịch hẹn.</p></div>
    </div>
    <form method="GET" class="grid md:grid-cols-4 gap-3 mb-6"><input name="q" value="{{ request('q') }}" class="bh-input md:col-span-2" placeholder="Mã thanh toán, mã lịch, khách hàng..."><select name="trang_thai" class="bh-input"><option value="">Tất cả trạng thái</option><option value="chua_thanh_toan" @selected(request('trang_thai') === 'chua_thanh_toan')>Chưa thanh toán</option><option value="da_thanh_toan" @selected(request('trang_thai') === 'da_thanh_toan')>Đã thanh toán</option><option value="that_bai" @selected(request('trang_thai') === 'that_bai')>Thất bại</option><option value="hoan_tien" @selected(request('trang_thai') === 'hoan_tien')>Hoàn tiền</option></select><button class="bh-btn-dark">Lọc</button></form>
    <div class="bh-table-wrap"><table class="bh-table"><thead><tr><th>Mã TT</th><th>Lịch hẹn</th><th>Khách hàng</th><th>Số tiền</th><th>Phương thức</th><th>Trạng thái</th><th>Ngày TT</th><th class="text-right">Thao tác</th></tr></thead><tbody>
    @forelse($thanhToan as $item)
        <tr><td class="font-black">{{ $item->ma_thanh_toan }}</td><td>{{ $item->lichHen->ma_lich_hen ?? '-' }}</td><td><div class="font-black">{{ $item->lichHen->khachHang->ho_ten ?? '-' }}</div><div class="text-xs text-slate-500 mt-1">{{ $item->lichHen->khachHang->so_dien_thoai ?? '' }}</div></td><td class="font-black text-orange-500 text-right">{{ number_format($item->so_tien) }}đ</td><td>{{ ['tien_mat'=>'Tiền mặt','chuyen_khoan'=>'Chuyển khoản','vi_dien_tu'=>'Ví điện tử','momo'=>'MoMo QR','vnpay'=>'VNPAY'][$item->phuong_thuc] ?? $item->phuong_thuc }}</td><td><x-badge-status :status="$item->trang_thai" /></td><td>{{ $item->ngay_thanh_toan?->format('d/m/Y H:i') ?? '-' }}</td><td><div class="flex justify-end gap-2 flex-wrap">@if($item->lichHen)<a href="{{ route('admin.thanh-toan.invoice', $item->lichHen) }}" class="bh-btn-light !px-3 !py-2">Hóa đơn</a>@endif<a href="{{ route('admin.thanh-toan.edit', $item) }}" class="rounded-2xl bg-blue-50 px-4 py-2 text-sm font-black text-blue-700">Sửa</a>@if($item->trang_thai !== 'da_thanh_toan')<form method="POST" action="{{ route('admin.thanh-toan.mark-paid', $item) }}">@csrf<input type="hidden" name="phuong_thuc" value="{{ $item->phuong_thuc }}"><button class="rounded-2xl bg-emerald-50 px-4 py-2 text-sm font-black text-emerald-700" onclick="return confirm('Xác nhận đã thanh toán?')">Xác nhận</button></form>@endif</div></td></tr>
    @empty
        <tr><td colspan="8" class="text-center text-slate-500 py-10">Chưa có thanh toán.</td></tr>
    @endforelse
    </tbody></table></div><div class="mt-6">{{ $thanhToan->links() }}</div>
</div>
@endsection
