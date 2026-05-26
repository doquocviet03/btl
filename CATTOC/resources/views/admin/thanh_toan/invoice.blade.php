@extends('admin.layouts.app')

@section('title', 'Hóa đơn lịch hẹn')
@section('content')
<div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
    <div class="flex justify-between items-start mb-6">
        <div>
            <h1 class="text-2xl font-bold">Hóa đơn #{{ $lichHen->ma_lich_hen }}</h1>
            <p class="text-slate-500">Ngày hẹn: {{ $lichHen->ngay_hen }} {{ $lichHen->gio_bat_dau }}</p>
        </div>
        <button onclick="window.print()" class="px-4 py-2 bg-slate-900 text-white rounded-xl">In hóa đơn</button>
    </div>

    <div class="grid md:grid-cols-2 gap-4 mb-6 text-sm">
        <div class="rounded-xl bg-slate-50 p-4">
            <div class="font-semibold mb-2">Khách hàng</div>
            <div>{{ $lichHen->khachHang->ho_ten ?? '-' }}</div>
            <div>{{ $lichHen->khachHang->so_dien_thoai ?? '-' }}</div>
        </div>
        <div class="rounded-xl bg-slate-50 p-4">
            <div class="font-semibold mb-2">Thợ cắt tóc</div>
            <div>{{ $lichHen->tho->ho_ten ?? $lichHen->thoCatToc->ho_ten ?? '-' }}</div>
            <div>Trạng thái: <x-badge-status :status="$lichHen->trang_thai" /></div>
        </div>
    </div>

    <table class="w-full text-sm mb-6">
        <thead><tr class="bg-slate-100"><th class="p-3 text-left">Dịch vụ</th><th class="p-3 text-right">Thời gian</th><th class="p-3 text-right">Giá</th></tr></thead>
        <tbody>
        @foreach($lichHen->chiTiet as $ct)
            <tr class="border-t"><td class="p-3">{{ $ct->ten_dich_vu }}</td><td class="p-3 text-right">{{ $ct->thoi_gian }} phút</td><td class="p-3 text-right">{{ number_format($ct->gia) }}đ</td></tr>
        @endforeach
        </tbody>
        <tfoot><tr class="border-t font-bold"><td class="p-3" colspan="2">Tổng tiền</td><td class="p-3 text-right">{{ number_format($lichHen->tong_tien) }}đ</td></tr></tfoot>
    </table>

    @if($lichHen->thanhToan && $lichHen->thanhToan->trang_thai !== 'da_thanh_toan')
        <form method="POST" action="{{ route('admin.thanh-toan.mark-paid', $lichHen->thanhToan->id) }}" class="rounded-xl border p-4 space-y-3">
            @csrf
            <h2 class="font-semibold">Xác nhận thanh toán</h2>
            <select name="phuong_thuc" class="w-full rounded-xl border-slate-300">
                <option value="tien_mat">Tiền mặt</option>
                <option value="chuyen_khoan">Chuyển khoản</option>
                <option value="vi_dien_tu">Ví điện tử</option>
                <option value="momo">MoMo QR</option>
                <option value="vnpay">VNPAY</option>
            </select>
            <textarea name="ghi_chu" rows="2" placeholder="Ghi chú thanh toán" class="w-full rounded-xl border-slate-300"></textarea>
            <button class="px-4 py-2 bg-green-600 text-white rounded-xl">Đã thanh toán</button>
        </form>
    @endif

    <div class="mt-6"><a href="{{ route('admin.lich-hen.index') }}" class="px-4 py-2 rounded-xl border">Quay lại</a></div>
</div>
@endsection
