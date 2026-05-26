<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LichHen extends Model
{
    protected $table = 'lich_hen';

    protected $fillable = [
        'ma_lich_hen',
        'khach_hang_id',
        'tho_id',
        'ngay_hen',
        'gio_bat_dau',
        'gio_ket_thuc',
        'tong_tien',
        'trang_thai',
        'ghi_chu',
        'ly_do_huy',
    ];

    protected $casts = [
        'ngay_hen' => 'date',
        'gio_bat_dau' => 'datetime:H:i',
        'gio_ket_thuc' => 'datetime:H:i',
        'tong_tien' => 'decimal:2',
    ];

    public function khachHang()
    {
        return $this->belongsTo(KhachHang::class, 'khach_hang_id');
    }

    public function tho()
    {
        return $this->belongsTo(ThoCatToc::class, 'tho_id');
    }

    public function thoCatToc()
    {
        return $this->belongsTo(ThoCatToc::class, 'tho_id');
    }

    public function chiTiet()
    {
        return $this->hasMany(ChiTietLichHen::class, 'lich_hen_id');
    }

    public function thanhToan()
    {
        return $this->hasOne(ThanhToan::class, 'lich_hen_id');
    }

    public function danhGia()
    {
        return $this->hasOne(DanhGia::class, 'lich_hen_id');
    }
}
