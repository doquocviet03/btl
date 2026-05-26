<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SanPham;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class SanPhamController extends Controller
{
    public function index(Request $request)
    {
        $sanPham = SanPham::query()
            ->when($request->q, fn ($q) => $q->where('ten_san_pham', 'like', '%' . $request->q . '%'))
            ->when($request->loai_san_pham, fn ($q) => $q->where('loai_san_pham', $request->loai_san_pham))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.san_pham.index', compact('sanPham'));
    }

    public function create()
    {
        $sanPham = new SanPham();
        return view('admin.san_pham.create', compact('sanPham'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = Str::slug($data['slug'] ?: $data['ten_san_pham']);
        $data['noi_bat'] = $request->boolean('noi_bat');
        $data['trang_thai'] = $request->boolean('trang_thai');

        SanPham::create($data);

        return redirect()->route('admin.san-pham.index')->with('success', 'Đã thêm sản phẩm mới.');
    }

    public function edit(SanPham $sanPham)
    {
        return view('admin.san_pham.edit', compact('sanPham'));
    }

    public function update(Request $request, SanPham $sanPham)
    {
        $data = $this->validated($request, $sanPham->id);
        $data['slug'] = Str::slug($data['slug'] ?: $data['ten_san_pham']);
        $data['noi_bat'] = $request->boolean('noi_bat');
        $data['trang_thai'] = $request->boolean('trang_thai');

        $sanPham->update($data);

        return redirect()->route('admin.san-pham.index')->with('success', 'Đã cập nhật sản phẩm.');
    }

    public function destroy(SanPham $sanPham)
    {
        $sanPham->delete();
        return back()->with('success', 'Đã xóa sản phẩm.');
    }

    private function validated(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'ten_san_pham' => ['required', 'string', 'max:180'],
            'slug' => ['nullable', 'string', 'max:220', Rule::unique('san_pham', 'slug')->ignore($ignoreId)],
            'thuong_hieu' => ['nullable', 'string', 'max:120'],
            'loai_san_pham' => ['required', Rule::in(['cham_soc_toc', 'cham_soc_da_dau', 'tao_kieu', 'combo'])],
            'gia' => ['required', 'numeric', 'min:0'],
            'gia_khuyen_mai' => ['nullable', 'numeric', 'min:0'],
            'so_luong_ton' => ['required', 'integer', 'min:0'],
            'dung_tich' => ['nullable', 'string', 'max:80'],
            'hinh_anh' => ['nullable', 'string', 'max:255'],
            'mo_ta_ngan' => ['nullable', 'string', 'max:1000'],
            'mo_ta_chi_tiet' => ['nullable', 'string'],
            'noi_bat' => ['nullable', 'boolean'],
            'trang_thai' => ['nullable', 'boolean'],
        ]);
    }
}
