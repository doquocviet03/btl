<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ThoCatToc;
use Illuminate\Http\Request;

class ThoCatTocController extends Controller
{
    public function index(Request $request)
    {
        $thoCatToc = ThoCatToc::query()
            ->when($request->q, fn ($q) => $q
                ->where('ho_ten', 'like', "%{$request->q}%")
                ->orWhere('so_dien_thoai', 'like', "%{$request->q}%")
                ->orWhere('email', 'like', "%{$request->q}%")
                ->orWhere('chuyen_mon', 'like', "%{$request->q}%"))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.tho_cat_toc.index', compact('thoCatToc'));
    }

    public function create()
    {
        return view('admin.tho_cat_toc.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'ho_ten' => ['required', 'string', 'max:100'],
            'so_dien_thoai' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:150'],
            'kinh_nghiem' => ['nullable', 'integer', 'min:0'],
            'chuyen_mon' => ['nullable', 'string', 'max:255'],
            'anh_dai_dien' => ['nullable', 'string', 'max:255'],
            'mo_ta' => ['nullable', 'string'],
            'trang_thai' => ['required', 'boolean'],
        ]);

        ThoCatToc::create($data);

        return redirect()->route('admin.tho-cat-toc.index')
            ->with('success', 'Thêm thợ cắt tóc thành công.');
    }

    public function edit(ThoCatToc $thoCatToc)
    {
        return view('admin.tho_cat_toc.edit', compact('thoCatToc'));
    }

    public function update(Request $request, ThoCatToc $thoCatToc)
    {
        $data = $request->validate([
            'ho_ten' => ['required', 'string', 'max:100'],
            'so_dien_thoai' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:150'],
            'kinh_nghiem' => ['nullable', 'integer', 'min:0'],
            'chuyen_mon' => ['nullable', 'string', 'max:255'],
            'anh_dai_dien' => ['nullable', 'string', 'max:255'],
            'mo_ta' => ['nullable', 'string'],
            'trang_thai' => ['required', 'boolean'],
        ]);

        $thoCatToc->update($data);

        return redirect()->route('admin.tho-cat-toc.index')
            ->with('success', 'Cập nhật thợ cắt tóc thành công.');
    }

    public function destroy(ThoCatToc $thoCatToc)
    {
        if ($thoCatToc->lichHen()->exists()) {
            return back()->with('error', 'Không thể xóa thợ đã có lịch hẹn.');
        }

        $thoCatToc->delete();

        return back()->with('success', 'Xóa thợ cắt tóc thành công.');
    }
}