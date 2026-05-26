@extends('admin.layouts.app')
@section('title', 'Xử lý đơn hàng')
@section('content')
<div class="grid lg:grid-cols-[1fr_.4fr] gap-6">
    <div class="bh-card p-6">
        <p class="bh-eyebrow">Order Detail</p>
        <h1 class="text-3xl font-black tracking-tight mt-2">{{ $donHang->ma_don_hang }}</h1>
        <div class="mt-6 bh-table-wrap">
            <table class="bh-table">
                <thead><tr><th>Sản phẩm</th><th>Đơn giá</th><th>Số lượng</th><th>Thành tiền</th></tr></thead>
                <tbody>
                @foreach($donHang->chiTiet as $ct)
                    <tr><td class="font-black">{{ $ct->ten_san_pham }}</td><td>{{ number_format($ct->don_gia) }}đ</td><td>{{ $ct->so_luong }}</td><td class="font-black text-orange-500">{{ number_format($ct->thanh_tien) }}đ</td></tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <aside class="bh-card p-6 h-fit">
        <h2 class="text-2xl font-black">Thông tin xử lý</h2>
        <div class="mt-5 space-y-3 text-sm font-bold text-slate-600">
            <div><span class="text-slate-400">Khách hàng</span><div class="text-slate-950">{{ $donHang->ho_ten }}</div></div>
            <div><span class="text-slate-400">SĐT</span><div class="text-slate-950">{{ $donHang->so_dien_thoai }}</div></div>
            <div><span class="text-slate-400">Địa chỉ</span><div class="text-slate-950">{{ $donHang->dia_chi }}</div></div>
            <div><span class="text-slate-400">Tổng tiền</span><div class="text-orange-500 text-2xl font-black">{{ number_format($donHang->tong_tien) }}đ</div></div>
            <div><span class="text-slate-400">Thanh toán</span><div><x-badge-status :status="$donHang->trang_thai_thanh_toan ?? 'chua_thanh_toan'" /></div></div>
            @if($donHang->momo_order_id)
                <div class="rounded-2xl bg-fuchsia-50 border border-fuchsia-100 p-3 text-xs">
                    <div><strong>MoMo Order:</strong> {{ $donHang->momo_order_id }}</div>
                    <div><strong>Trans ID:</strong> {{ $donHang->momo_trans_id ?? 'Chưa có' }}</div>
                    <div><strong>Message:</strong> {{ $donHang->momo_message ?? '-' }}</div>
                </div>
            @endif
            @if($donHang->vnpay_txn_ref)
                <div class="rounded-2xl bg-blue-50 border border-blue-100 p-3 text-xs">
                    <div><strong>VNPAY TxnRef:</strong> {{ $donHang->vnpay_txn_ref }}</div>
                    <div><strong>Transaction No:</strong> {{ $donHang->vnpay_transaction_no ?? 'Chưa có' }}</div>
                    <div><strong>Response:</strong> {{ $donHang->vnpay_response_code ?? '-' }} / {{ $donHang->vnpay_transaction_status ?? '-' }}</div>
                    <div><strong>Ngân hàng:</strong> {{ $donHang->vnpay_bank_code ?? '-' }}</div>
                </div>
            @endif
        </div>
        <form method="POST" action="{{ route('admin.don-hang.update', $donHang) }}" class="mt-6 space-y-4">
            @csrf @method('PUT')
            <div><label class="bh-label">Trạng thái</label><select name="trang_thai" class="bh-input"><option value="cho_xac_nhan" @selected($donHang->trang_thai==='cho_xac_nhan')>Chờ xác nhận</option><option value="dang_chuan_bi" @selected($donHang->trang_thai==='dang_chuan_bi')>Đang chuẩn bị</option><option value="dang_giao" @selected($donHang->trang_thai==='dang_giao')>Đang giao</option><option value="hoan_thanh" @selected($donHang->trang_thai==='hoan_thanh')>Hoàn thành</option><option value="da_huy" @selected($donHang->trang_thai==='da_huy')>Đã hủy</option></select></div>
            <div><label class="bh-label">Trạng thái thanh toán</label><select name="trang_thai_thanh_toan" class="bh-input"><option value="chua_thanh_toan" @selected(old('trang_thai_thanh_toan', $donHang->trang_thai_thanh_toan)==='chua_thanh_toan')>Chưa thanh toán</option><option value="dang_cho_xac_nhan" @selected(old('trang_thai_thanh_toan', $donHang->trang_thai_thanh_toan)==='dang_cho_xac_nhan')>Đang chờ xác nhận</option><option value="da_thanh_toan" @selected(old('trang_thai_thanh_toan', $donHang->trang_thai_thanh_toan)==='da_thanh_toan')>Đã thanh toán</option><option value="that_bai" @selected(old('trang_thai_thanh_toan', $donHang->trang_thai_thanh_toan)==='that_bai')>Thất bại</option><option value="hoan_tien" @selected(old('trang_thai_thanh_toan', $donHang->trang_thai_thanh_toan)==='hoan_tien')>Hoàn tiền</option></select></div>
            <div><label class="bh-label">Ghi chú</label><textarea name="ghi_chu" class="bh-input" rows="4">{{ old('ghi_chu', $donHang->ghi_chu) }}</textarea></div>
            <button class="bh-btn-primary w-full">Cập nhật đơn hàng</button>
            <a href="{{ route('admin.don-hang.index') }}" class="bh-btn-light w-full">Quay lại</a>
        </form>
    </aside>
</div>
@endsection
