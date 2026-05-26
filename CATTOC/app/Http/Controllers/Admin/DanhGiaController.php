<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DanhGia;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DanhGiaController extends Controller
{
    public function index(Request $request)
    {
        $danhGia = DanhGia::with(['khachHang', 'tho', 'lichHen'])
            ->when($request->q, fn ($q) => $q->where('noi_dung', 'like', '%' . $request->q . '%'))
            ->when($request->trang_thai, fn ($q) => $q->where('trang_thai', $request->trang_thai))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.danh_gia.index', compact('danhGia'));
    }

    public function create()
    {
        return redirect()->route('admin.danh-gia.index')
            ->with('error', 'Đánh giá được tạo từ khách hàng sau khi hoàn thành lịch hẹn.');
    }

    public function store(Request $request)
    {
        return redirect()->route('admin.danh-gia.index');
    }

    public function edit(DanhGia $danhGia)
    {
        return view('admin.danh_gia.edit', compact('danhGia'));
    }

    public function update(Request $request, DanhGia $danhGia)
    {
        $data = $request->validate([
            'so_sao' => ['required', 'integer', 'min:1', 'max:5'],
            'noi_dung' => ['nullable', 'string'],
            'trang_thai' => ['required', Rule::in(['cho_duyet', 'da_duyet', 'an'])],
        ]);

        $danhGia->update($data);

        return redirect()->route('admin.danh-gia.index')
            ->with('success', 'Cập nhật đánh giá thành công.');
    }

    public function destroy(DanhGia $danhGia)
    {
        $danhGia->delete();

        return back()->with('success', 'Xóa đánh giá thành công.');
    }
}
