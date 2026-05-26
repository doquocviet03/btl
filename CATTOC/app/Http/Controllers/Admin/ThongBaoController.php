<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ThongBao;

class ThongBaoController extends Controller
{
    public function latest()
    {
        return response()->json([
            'unread_count' => ThongBao::where('da_doc', 0)->count(),
            'items' => ThongBao::latest()->limit(5)->get(),
        ]);
    }

    public function markAsRead()
    {
        ThongBao::where('da_doc', 0)->update([
            'da_doc' => 1,
        ]);

        return response()->json([
            'message' => 'Đã đọc thông báo',
        ]);
    }
}