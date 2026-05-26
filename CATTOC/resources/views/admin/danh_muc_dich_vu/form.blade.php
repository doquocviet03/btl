@csrf
<div>
    <label class="block text-sm font-semibold mb-1">Tên danh mục <span class="text-red-500">*</span></label>
    <input name="ten_danh_muc" value="{{ old('ten_danh_muc', $danhMucDichVu->ten_danh_muc ?? '') }}" class="w-full rounded-xl border-slate-300" required>
</div>
<div>
    <label class="block text-sm font-semibold mb-1">Mô tả</label>
    <textarea name="mo_ta" rows="4" class="w-full rounded-xl border-slate-300">{{ old('mo_ta', $danhMucDichVu->mo_ta ?? '') }}</textarea>
</div>
<div>
    <label class="block text-sm font-semibold mb-1">Trạng thái</label>
    <select name="trang_thai" class="w-full rounded-xl border-slate-300">
        <option value="1" @selected(old('trang_thai', $danhMucDichVu->trang_thai ?? 1) == 1)>Hiển thị</option>
        <option value="0" @selected(old('trang_thai', $danhMucDichVu->trang_thai ?? 1) == 0)>Ẩn</option>
    </select>
</div>
<div class="flex justify-end gap-3 pt-4">
    <a href="{{ route('admin.danh-muc-dich-vu.index') }}" class="px-4 py-2 rounded-xl border">Quay lại</a>
    <button class="px-5 py-2 rounded-xl bg-slate-900 text-white">Lưu</button>
</div>
