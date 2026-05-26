<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChiTietLichHen extends Model
{
    protected $table = 'chi_tiet_lich_hen';

    protected $fillable = [
        'lich_hen_id',
        'dich_vu_id',
        'ten_dich_vu',
        'gia',
        'thoi_gian',
    ];

    protected $casts = [
        'gia' => 'decimal:2',
    ];

    public function lichHen()
    {
        return $this->belongsTo(LichHen::class, 'lich_hen_id');
    }

    public function dichVu()
    {
        return $this->belongsTo(DichVu::class, 'dich_vu_id');
    }
}