<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThongBao extends Model
{
    protected $table = 'thong_bao';

    protected $fillable = [
        'tieu_de',
        'noi_dung',
        'loai',
        'lien_ket',
        'da_doc',
    ];

    protected $casts = [
        'da_doc' => 'boolean',
    ];
}