<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DanhMucDichVu;
use App\Models\DichVu;
use Illuminate\Http\Request;

class DichVuController extends Controller
{
    public function index(Request $request)
    {
        $dichVu = DichVu::with('danhMuc')
            ->when($request->q, fn ($q) => $q->where('ten_dich_vu', 'like', "%{$request->q}%"))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.dich_vu.index', compact('dichVu'));
    }

    public function create()
    {
        $danhMuc = DanhMucDichVu::where('trang_thai', 1)->orderBy('ten_danh_muc')->get();

        return view('admin.dich_vu.create', compact('danhMuc'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'danh_muc_id' => ['nullable', 'exists:danh_muc_dich_vu,id'],
            'ten_dich_vu' => ['required', 'string', 'max:150'],
            'gia' => ['required', 'numeric', 'min:0'],
            'thoi_gian' => ['required', 'integer', 'min:1'],
            'mo_ta' => ['nullable', 'string'],
            'hinh_anh' => ['nullable', 'string', 'max:255'],
            'trang_thai' => ['required', 'boolean'],
        ]);

        DichVu::create($data);

        return redirect()->route('admin.dich-vu.index')
            ->with('success', 'Thêm dịch vụ thành công.');
    }

    public function edit(DichVu $dichVu)
    {
        $danhMuc = DanhMucDichVu::where('trang_thai', 1)->orderBy('ten_danh_muc')->get();

        return view('admin.dich_vu.edit', compact('dichVu', 'danhMuc'));
    }

    public function update(Request $request, DichVu $dichVu)
    {
        $data = $request->validate([
            'danh_muc_id' => ['nullable', 'exists:danh_muc_dich_vu,id'],
            'ten_dich_vu' => ['required', 'string', 'max:150'],
            'gia' => ['required', 'numeric', 'min:0'],
            'thoi_gian' => ['required', 'integer', 'min:1'],
            'mo_ta' => ['nullable', 'string'],
            'hinh_anh' => ['nullable', 'string', 'max:255'],
            'trang_thai' => ['required', 'boolean'],
        ]);

        $dichVu->update($data);

        return redirect()->route('admin.dich-vu.index')
            ->with('success', 'Cập nhật dịch vụ thành công.');
    }

    public function destroy(DichVu $dichVu)
    {
        if ($dichVu->chiTietLichHen()->exists()) {
            return back()->with('error', 'Không thể xóa dịch vụ đã được dùng trong lịch hẹn.');
        }

        $dichVu->delete();

        return back()->with('success', 'Xóa dịch vụ thành công.');
    }
}