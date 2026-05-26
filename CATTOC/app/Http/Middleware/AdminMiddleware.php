<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || auth()->user()->vai_tro !== 'admin') {
            abort(403, 'Bạn không có quyền truy cập trang quản trị.');
        }

        return $next($request);
    }
}