<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DonHang;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DonHangController extends Controller
{
    public function index(Request $request)
    {
        $donHang = DonHang::withCount('chiTiet')
            ->when($request->q, fn ($q) => $q->where(function ($sub) use ($request) {
                $sub->where('ma_don_hang', 'like', '%' . $request->q . '%')
                    ->orWhere('ho_ten', 'like', '%' . $request->q . '%')
                    ->orWhere('so_dien_thoai', 'like', '%' . $request->q . '%');
            }))
            ->when($request->trang_thai, fn ($q) => $q->where('trang_thai', $request->trang_thai))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.don_hang.index', compact('donHang'));
    }

    public function edit(DonHang $donHang)
    {
        $donHang->load('chiTiet');
        return view('admin.don_hang.edit', compact('donHang'));
    }

    public function update(Request $request, DonHang $donHang)
    {
        $data = $request->validate([
            'trang_thai' => ['required', Rule::in(['cho_xac_nhan', 'dang_chuan_bi', 'dang_giao', 'hoan_thanh', 'da_huy'])],
            'trang_thai_thanh_toan' => ['nullable', Rule::in(['chua_thanh_toan', 'dang_cho_xac_nhan', 'da_thanh_toan', 'that_bai', 'hoan_tien'])],
            'ghi_chu' => ['nullable', 'string', 'max:1000'],
        ]);

        $donHang->update($data);

        return redirect()->route('admin.don-hang.index')->with('success', 'Đã cập nhật đơn hàng.');
    }

    public function destroy(DonHang $donHang)
    {
        $donHang->delete();
        return back()->with('success', 'Đã xóa đơn hàng.');
    }
}
