<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThoCatToc extends Model
{
    protected $table = 'tho_cat_toc';

    protected $fillable = [
        'tai_khoan_id',
        'ho_ten',
        'so_dien_thoai',
        'email',
        'kinh_nghiem',
        'chuyen_mon',
        'anh_dai_dien',
        'mo_ta',
        'trang_thai',
    ];

    protected $casts = [
        'trang_thai' => 'boolean',
    ];

    public function lichHen()
    {
        return $this->hasMany(LichHen::class, 'tho_id');
    }

    public function lichLamViec()
    {
        return $this->hasMany(LichLamViecTho::class, 'tho_id');
    }

    public function taiKhoan()
    {
        return $this->belongsTo(TaiKhoan::class, 'tai_khoan_id');
    }

    public function danhGia()
    {
        return $this->hasMany(DanhGia::class, 'tho_id');
    }
}
