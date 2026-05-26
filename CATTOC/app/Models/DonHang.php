<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DonHang extends Model
{
    protected $table = 'don_hang';

    protected $fillable = [
        'ma_don_hang', 'khach_hang_id', 'ho_ten', 'so_dien_thoai', 'email', 'dia_chi',
        'tong_tien', 'phuong_thuc_thanh_toan', 'trang_thai', 'trang_thai_thanh_toan', 'ghi_chu',
        'momo_order_id', 'momo_request_id', 'momo_pay_url', 'momo_deeplink', 'momo_qr_code',
        'momo_trans_id', 'momo_result_code', 'momo_message', 'momo_payload',
        'vnpay_txn_ref', 'vnpay_payment_url', 'vnpay_transaction_no', 'vnpay_response_code',
        'vnpay_transaction_status', 'vnpay_bank_code', 'vnpay_pay_date', 'vnpay_payload',
    ];

    protected $casts = [
        'tong_tien' => 'decimal:2',
    ];

    public function khachHang()
    {
        return $this->belongsTo(KhachHang::class, 'khach_hang_id');
    }

    public function chiTiet()
    {
        return $this->hasMany(ChiTietDonHang::class, 'don_hang_id');
    }
}
