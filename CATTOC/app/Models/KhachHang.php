<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KhachHang extends Model
{
    protected $table = 'khach_hang';

    protected $fillable = [
        'tai_khoan_id',
        'ho_ten',
        'so_dien_thoai',
        'email',
        'gioi_tinh',
        'ngay_sinh',
        'dia_chi',
        'ghi_chu',
        'trang_thai',
    ];

    protected $casts = [
        'ngay_sinh' => 'date',
        'trang_thai' => 'boolean',
    ];

    public function taiKhoan()
    {
        return $this->belongsTo(TaiKhoan::class, 'tai_khoan_id');
    }

    public function lichHen()
    {
        return $this->hasMany(LichHen::class, 'khach_hang_id');
    }

    public function danhGia()
    {
        return $this->hasMany(DanhGia::class, 'khach_hang_id');
    }

    public function donHang()
    {
        return $this->hasMany(DonHang::class, 'khach_hang_id');
    }
}
