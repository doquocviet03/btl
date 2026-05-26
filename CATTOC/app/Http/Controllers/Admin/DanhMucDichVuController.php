<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DanhMucDichVu;
use Illuminate\Http\Request;

class DanhMucDichVuController extends Controller
{
    public function index(Request $request)
    {
        $danhMuc = DanhMucDichVu::query()
            ->when($request->q, fn ($q) => $q->where('ten_danh_muc', 'like', "%{$request->q}%"))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.danh_muc_dich_vu.index', compact('danhMuc'));
    }

    public function create()
    {
        return view('admin.danh_muc_dich_vu.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'ten_danh_muc' => ['required', 'string', 'max:100'],
            'mo_ta' => ['nullable', 'string'],
            'trang_thai' => ['required', 'boolean'],
        ]);

        DanhMucDichVu::create($data);

        return redirect()->route('admin.danh-muc-dich-vu.index')
            ->with('success', 'Thêm danh mục thành công.');
    }

    public function edit(DanhMucDichVu $danhMucDichVu)
    {
        return view('admin.danh_muc_dich_vu.edit', compact('danhMucDichVu'));
    }

    public function update(Request $request, DanhMucDichVu $danhMucDichVu)
    {
        $data = $request->validate([
            'ten_danh_muc' => ['required', 'string', 'max:100'],
            'mo_ta' => ['nullable', 'string'],
            'trang_thai' => ['required', 'boolean'],
        ]);

        $danhMucDichVu->update($data);

        return redirect()->route('admin.danh-muc-dich-vu.index')
            ->with('success', 'Cập nhật danh mục thành công.');
    }

    public function destroy(DanhMucDichVu $danhMucDichVu)
    {
        if ($danhMucDichVu->dichVu()->exists()) {
            return back()->with('error', 'Không thể xóa danh mục đang có dịch vụ.');
        }

        $danhMucDichVu->delete();

        return back()->with('success', 'Xóa danh mục thành công.');
    }
}