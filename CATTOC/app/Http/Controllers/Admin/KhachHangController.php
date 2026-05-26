<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KhachHang;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KhachHangController extends Controller
{
    public function index(Request $request)
    {
        $khachHang = KhachHang::query()
            ->when($request->q, fn ($q) => $q
                ->where('ho_ten', 'like', "%{$request->q}%")
                ->orWhere('so_dien_thoai', 'like', "%{$request->q}%")
                ->orWhere('email', 'like', "%{$request->q}%"))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.khach_hang.index', compact('khachHang'));
    }

    public function create()
    {
        return view('admin.khach_hang.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'ho_ten' => ['required', 'string', 'max:100'],
            'so_dien_thoai' => ['required', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:150'],
            'gioi_tinh' => ['nullable', Rule::in(['nam', 'nu', 'khac'])],
            'ngay_sinh' => ['nullable', 'date'],
            'dia_chi' => ['nullable', 'string', 'max:255'],
            'ghi_chu' => ['nullable', 'string'],
            'trang_thai' => ['required', 'boolean'],
        ]);

        KhachHang::create($data);

        return redirect()->route('admin.khach-hang.index')
            ->with('success', 'Thêm khách hàng thành công.');
    }

    public function edit(KhachHang $khachHang)
    {
        return view('admin.khach_hang.edit', compact('khachHang'));
    }

    public function update(Request $request, KhachHang $khachHang)
    {
        $data = $request->validate([
            'ho_ten' => ['required', 'string', 'max:100'],
            'so_dien_thoai' => ['required', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:150'],
            'gioi_tinh' => ['nullable', Rule::in(['nam', 'nu', 'khac'])],
            'ngay_sinh' => ['nullable', 'date'],
            'dia_chi' => ['nullable', 'string', 'max:255'],
            'ghi_chu' => ['nullable', 'string'],
            'trang_thai' => ['required', 'boolean'],
        ]);

        $khachHang->update($data);

        return redirect()->route('admin.khach-hang.index')
            ->with('success', 'Cập nhật khách hàng thành công.');
    }

    public function destroy(KhachHang $khachHang)
    {
        if ($khachHang->lichHen()->exists()) {
            return back()->with('error', 'Không thể xóa khách hàng đã có lịch hẹn.');
        }

        $khachHang->delete();

        return back()->with('success', 'Xóa khách hàng thành công.');
    }
}