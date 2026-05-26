<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DanhMucDichVu extends Model
{
    protected $table = 'danh_muc_dich_vu';

    protected $fillable = [
        'ten_danh_muc',
        'mo_ta',
        'trang_thai',
    ];

    public function dichVu()
    {
        return $this->hasMany(DichVu::class, 'danh_muc_id');
    }
}