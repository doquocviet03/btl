<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TaiKhoan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class TaiKhoanController extends Controller
{
    public function index(Request $request)
    {
        $taiKhoan = TaiKhoan::query()
            ->when($request->q, fn ($q) => $q
                ->where('ho_ten', 'like', "%{$request->q}%")
                ->orWhere('email', 'like', "%{$request->q}%")
                ->orWhere('so_dien_thoai', 'like', "%{$request->q}%"))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.tai_khoan.index', compact('taiKhoan'));
    }

    public function create()
    {
        return view('admin.tai_khoan.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'ho_ten' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150', 'unique:tai_khoan,email'],
            'so_dien_thoai' => ['nullable', 'string', 'max:20'],
            'mat_khau' => ['required', 'string', 'min:8'],
            'vai_tro' => ['required', Rule::in(['admin', 'khach_hang', 'tho'])],
            'trang_thai' => ['required', 'boolean'],
        ]);

        $data['mat_khau'] = Hash::make($data['mat_khau']);

        TaiKhoan::create($data);

        return redirect()->route('admin.tai-khoan.index')
            ->with('success', 'Thêm tài khoản thành công.');
    }

    public function edit(TaiKhoan $taiKhoan)
    {
        return view('admin.tai_khoan.edit', compact('taiKhoan'));
    }

    public function update(Request $request, TaiKhoan $taiKhoan)
    {
        $data = $request->validate([
            'ho_ten' => ['required', 'string', 'max:100'],
            'email' => [
                'required',
                'email',
                'max:150',
                Rule::unique('tai_khoan', 'email')->ignore($taiKhoan->id),
            ],
            'so_dien_thoai' => ['nullable', 'string', 'max:20'],
            'mat_khau' => ['nullable', 'string', 'min:8'],
            'vai_tro' => ['required', Rule::in(['admin', 'khach_hang', 'tho'])],
            'trang_thai' => ['required', 'boolean'],
        ]);

        if (!empty($data['mat_khau'])) {
            $data['mat_khau'] = Hash::make($data['mat_khau']);
        } else {
            unset($data['mat_khau']);
        }

        $taiKhoan->update($data);

        return redirect()->route('admin.tai-khoan.index')
            ->with('success', 'Cập nhật tài khoản thành công.');
    }

    public function destroy(TaiKhoan $taiKhoan)
    {
        if (Auth::id() === $taiKhoan->id) {
            return back()->with('error', 'Không thể xóa chính tài khoản đang đăng nhập.');
        }

        $taiKhoan->delete();

        return back()->with('success', 'Xóa tài khoản thành công.');
    }
}