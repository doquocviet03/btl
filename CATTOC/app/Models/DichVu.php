<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DichVu extends Model
{
    protected $table = 'dich_vu';

    protected $fillable = [
        'danh_muc_id',
        'ten_dich_vu',
        'gia',
        'thoi_gian',
        'mo_ta',
        'hinh_anh',
        'trang_thai',
    ];

    public function danhMuc()
    {
        return $this->belongsTo(DanhMucDichVu::class, 'danh_muc_id');
    }

    public function chiTietLichHen()
    {
        return $this->hasMany(ChiTietLichHen::class, 'dich_vu_id');
    }
}