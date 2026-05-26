<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThanhToan extends Model
{
    protected $table = 'thanh_toan';

    protected $fillable = [
        'lich_hen_id',
        'ma_thanh_toan',
        'so_tien',
        'phuong_thuc',
        'trang_thai',
        'ngay_thanh_toan',
        'ghi_chu',
        'momo_order_id',
        'momo_request_id',
        'momo_pay_url',
        'momo_deeplink',
        'momo_qr_code',
        'momo_trans_id',
        'momo_result_code',
        'momo_message',
        'momo_payload',
        'vnpay_txn_ref',
        'vnpay_payment_url',
        'vnpay_transaction_no',
        'vnpay_response_code',
        'vnpay_transaction_status',
        'vnpay_bank_code',
        'vnpay_pay_date',
        'vnpay_payload',
    ];

    protected $casts = [
        'so_tien' => 'decimal:2',
        'ngay_thanh_toan' => 'datetime',
    ];

    public function lichHen()
    {
        return $this->belongsTo(LichHen::class, 'lich_hen_id');
    }
}