<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DanhGia extends Model
{
    protected $table = 'danh_gia';

    protected $fillable = [
        'lich_hen_id',
        'khach_hang_id',
        'tho_id',
        'so_sao',
        'noi_dung',
        'trang_thai',
    ];

    public function khachHang()
    {
        return $this->belongsTo(KhachHang::class, 'khach_hang_id');
    }

    public function tho()
    {
        return $this->belongsTo(ThoCatToc::class, 'tho_id');
    }

    public function lichHen()
    {
        return $this->belongsTo(LichHen::class, 'lich_hen_id');
    }
}