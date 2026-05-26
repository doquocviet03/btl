<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChiTietDonHang extends Model
{
    protected $table = 'chi_tiet_don_hang';

    protected $fillable = [
        'don_hang_id', 'san_pham_id', 'ten_san_pham', 'don_gia', 'so_luong', 'thanh_tien',
    ];

    protected $casts = [
        'don_gia' => 'decimal:2',
        'thanh_tien' => 'decimal:2',
    ];

    public function donHang()
    {
        return $this->belongsTo(DonHang::class, 'don_hang_id');
    }

    public function sanPham()
    {
        return $this->belongsTo(SanPham::class, 'san_pham_id');
    }
}
