@extends('admin.layouts.app')

@section('title', 'Sửa thanh toán')
@section('page_title', 'Sửa thanh toán')

@section('content')
<div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold">Thanh toán {{ $thanhToan->ma_thanh_toan }}</h1>
        <p class="text-slate-500">Lịch hẹn: {{ $thanhToan->lichHen->ma_lich_hen ?? '-' }} - Khách: {{ $thanhToan->lichHen->khachHang->ho_ten ?? '-' }}</p>
        @if($thanhToan->momo_order_id)
            <div class="mt-4 rounded-2xl bg-fuchsia-50 border border-fuchsia-100 p-4 text-sm">
                <div><strong>MoMo Order ID:</strong> {{ $thanhToan->momo_order_id }}</div>
                <div><strong>MoMo Trans ID:</strong> {{ $thanhToan->momo_trans_id ?? 'Chưa có' }}</div>
                <div><strong>MoMo Message:</strong> {{ $thanhToan->momo_message ?? '-' }}</div>
            </div>
        @endif
        @if($thanhToan->vnpay_txn_ref)
            <div class="mt-4 rounded-2xl bg-blue-50 border border-blue-100 p-4 text-sm">
                <div><strong>VNPAY TxnRef:</strong> {{ $thanhToan->vnpay_txn_ref }}</div>
                <div><strong>VNPAY Transaction No:</strong> {{ $thanhToan->vnpay_transaction_no ?? 'Chưa có' }}</div>
                <div><strong>VNPAY Response:</strong> {{ $thanhToan->vnpay_response_code ?? '-' }} / {{ $thanhToan->vnpay_transaction_status ?? '-' }}</div>
                <div><strong>Ngân hàng:</strong> {{ $thanhToan->vnpay_bank_code ?? '-' }}</div>
            </div>
        @endif
    </div>

    <form method="POST" action="{{ route('admin.thanh-toan.update', $thanhToan) }}" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block font-medium mb-1">Số tiền</label>
            <input type="number" name="so_tien" value="{{ old('so_tien', $thanhToan->so_tien) }}" class="w-full rounded-xl border-slate-300" min="0">
            @error('so_tien') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block font-medium mb-1">Phương thức</label>
                <select name="phuong_thuc" class="w-full rounded-xl border-slate-300">
                    <option value="tien_mat" @selected(old('phuong_thuc', $thanhToan->phuong_thuc) === 'tien_mat')>Tiền mặt</option>
                    <option value="chuyen_khoan" @selected(old('phuong_thuc', $thanhToan->phuong_thuc) === 'chuyen_khoan')>Chuyển khoản</option>
                    <option value="vi_dien_tu" @selected(old('phuong_thuc', $thanhToan->phuong_thuc) === 'vi_dien_tu')>Ví điện tử khác</option>
                    <option value="momo" @selected(old('phuong_thuc', $thanhToan->phuong_thuc) === 'momo')>MoMo QR</option>
                    <option value="vnpay" @selected(old('phuong_thuc', $thanhToan->phuong_thuc) === 'vnpay')>VNPAY Sandbox</option>
                </select>
            </div>

            <div>
                <label class="block font-medium mb-1">Trạng thái</label>
                <select name="trang_thai" class="w-full rounded-xl border-slate-300">
                    <option value="chua_thanh_toan" @selected(old('trang_thai', $thanhToan->trang_thai) === 'chua_thanh_toan')>Chưa thanh toán</option>
                    <option value="da_thanh_toan" @selected(old('trang_thai', $thanhToan->trang_thai) === 'da_thanh_toan')>Đã thanh toán</option>
                    <option value="that_bai" @selected(old('trang_thai', $thanhToan->trang_thai) === 'that_bai')>Thất bại</option>
                    <option value="hoan_tien" @selected(old('trang_thai', $thanhToan->trang_thai) === 'hoan_tien')>Hoàn tiền</option>
                </select>
            </div>
        </div>

        <div>
            <label class="block font-medium mb-1">Ngày thanh toán</label>
            <input type="datetime-local" name="ngay_thanh_toan" value="{{ old('ngay_thanh_toan', $thanhToan->ngay_thanh_toan?->format('Y-m-d\\TH:i')) }}" class="w-full rounded-xl border-slate-300">
            <p class="text-xs text-slate-500 mt-1">Có thể để trống. Nếu chọn “Đã thanh toán”, hệ thống tự lấy thời gian hiện tại.</p>
        </div>

        <div>
            <label class="block font-medium mb-1">Ghi chú</label>
            <textarea name="ghi_chu" rows="4" class="w-full rounded-xl border-slate-300">{{ old('ghi_chu', $thanhToan->ghi_chu) }}</textarea>
        </div>

        <div class="flex justify-between items-center pt-4">
            <a href="{{ route('admin.thanh-toan.index') }}" class="px-4 py-2 rounded-xl border">Quay lại</a>
            <button class="px-5 py-2 bg-slate-900 text-white rounded-xl">Lưu thay đổi</button>
        </div>
    </form>
</div>
@endsection
