<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class TaiKhoan extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'tai_khoan';

    protected $fillable = [
        'ho_ten',
        'email',
        'mat_khau',
        'so_dien_thoai',
        'vai_tro',
        'trang_thai',
        'email_verified_at',
    ];

    protected $hidden = [
        'mat_khau',
        'remember_token',
    ];

    protected $casts = [
        'trang_thai' => 'boolean',
        'email_verified_at' => 'datetime',
    ];

    public function getAuthPassword()
    {
        return $this->mat_khau;
    }

    public function khachHang()
    {
        return $this->hasOne(KhachHang::class, 'tai_khoan_id');
    }

    public function thoCatToc()
    {
        return $this->hasOne(ThoCatToc::class, 'tai_khoan_id');
    }
}
