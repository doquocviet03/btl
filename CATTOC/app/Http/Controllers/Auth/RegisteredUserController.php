<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\KhachHang;
use App\Models\TaiKhoan;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'ho_ten' => ['required', 'string', 'max:100'],
            'so_dien_thoai' => ['nullable', 'string', 'max:20'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:150', 'unique:tai_khoan,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $taiKhoan = DB::transaction(function () use ($request) {
            $taiKhoan = TaiKhoan::create([
                'ho_ten' => $request->ho_ten,
                'email' => $request->email,
                'mat_khau' => Hash::make($request->password),
                'so_dien_thoai' => $request->so_dien_thoai,
                'vai_tro' => 'khach_hang',
                'trang_thai' => 1,
                'email_verified_at' => now(),
            ]);

            KhachHang::create([
                'tai_khoan_id' => $taiKhoan->id,
                'ho_ten' => $taiKhoan->ho_ten,
                'so_dien_thoai' => $taiKhoan->so_dien_thoai ?? '',
                'email' => $taiKhoan->email,
                'trang_thai' => 1,
            ]);

            return $taiKhoan;
        });

        event(new Registered($taiKhoan));

        Auth::login($taiKhoan);

        return redirect(route('dashboard', absolute: false));
    }
}
