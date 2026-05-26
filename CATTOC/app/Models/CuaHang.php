<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CuaHang extends Model
{
    protected $table = 'cua_hang';

    protected $fillable = [
        'ten_cua_hang', 'slug', 'thanh_pho', 'dia_chi', 'so_dien_thoai', 'email',
        'gio_mo_cua', 'ban_do_url', 'hinh_anh', 'mo_ta', 'trang_thai',
    ];

    protected $casts = [
        'trang_thai' => 'boolean',
    ];
}
