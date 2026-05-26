<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaiViet extends Model
{
    protected $table = 'bai_viet';

    protected $fillable = [
        'tieu_de', 'slug', 'anh_dai_dien', 'tom_tat', 'noi_dung', 'tac_gia', 'trang_thai', 'xuat_ban_luc',
    ];

    protected $casts = [
        'trang_thai' => 'boolean',
        'xuat_ban_luc' => 'datetime',
    ];
}
