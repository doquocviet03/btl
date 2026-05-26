<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SanPham extends Model
{
    protected $table = 'san_pham';

    protected $fillable = [
        'ten_san_pham', 'slug', 'thuong_hieu', 'loai_san_pham', 'gia', 'gia_khuyen_mai',
        'so_luong_ton', 'dung_tich', 'hinh_anh', 'mo_ta_ngan', 'mo_ta_chi_tiet',
        'noi_bat', 'trang_thai',
    ];

    protected $casts = [
        'gia' => 'decimal:2',
        'gia_khuyen_mai' => 'decimal:2',
        'noi_bat' => 'boolean',
        'trang_thai' => 'boolean',
    ];

    public function getGiaBanAttribute(): float
    {
        return (float) ($this->gia_khuyen_mai ?: $this->gia);
    }

    public function chiTietDonHang()
    {
        return $this->hasMany(ChiTietDonHang::class, 'san_pham_id');
    }
}
