<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LichLamViecTho extends Model
{
    protected $table = 'lich_lam_viec_tho';

    protected $fillable = [
        'tho_id',
        'ngay_lam',
        'ca_lam',
        'gio_bat_dau',
        'gio_ket_thuc',
        'trang_thai',
        'ghi_chu',
    ];

    protected $casts = [
        'ngay_lam' => 'date',
        'trang_thai' => 'boolean',
    ];

    public function tho()
    {
        return $this->belongsTo(ThoCatToc::class, 'tho_id');
    }
}
