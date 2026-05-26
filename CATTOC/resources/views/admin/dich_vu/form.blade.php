@csrf
<div>
    <label class="block text-sm font-semibold mb-1">Danh mục</label>
    <select name="danh_muc_id" class="w-full rounded-xl border-slate-300">
        <option value="">-- Không chọn --</option>
        @foreach($danhMuc as $dm)
            <option value="{{ $dm->id }}" @selected(old('danh_muc_id', $dichVu->danh_muc_id ?? '') == $dm->id)>{{ $dm->ten_danh_muc }}</option>
        @endforeach
    </select>
</div>
<div>
    <label class="block text-sm font-semibold mb-1">Tên dịch vụ <span class="text-red-500">*</span></label>
    <input name="ten_dich_vu" value="{{ old('ten_dich_vu', $dichVu->ten_dich_vu ?? '') }}" class="w-full rounded-xl border-slate-300" required>
</div>
<div class="grid md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-semibold mb-1">Giá <span class="text-red-500">*</span></label>
        <input type="number" name="gia" min="0" value="{{ old('gia', $dichVu->gia ?? 0) }}" class="w-full rounded-xl border-slate-300" required>
    </div>
    <div>
        <label class="block text-sm font-semibold mb-1">Thời gian/phút <span class="text-red-500">*</span></label>
        <input type="number" name="thoi_gian" min="1" value="{{ old('thoi_gian', $dichVu->thoi_gian ?? 30) }}" class="w-full rounded-xl border-slate-300" required>
    </div>
</div>
<div>
    <label class="block text-sm font-semibold mb-1">Link hình ảnh</label>
    <input name="hinh_anh" value="{{ old('hinh_anh', $dichVu->hinh_anh ?? '') }}" class="w-full rounded-xl border-slate-300">
</div>
<div>
    <label class="block text-sm font-semibold mb-1">Mô tả</label>
    <textarea name="mo_ta" rows="4" class="w-full rounded-xl border-slate-300">{{ old('mo_ta', $dichVu->mo_ta ?? '') }}</textarea>
</div>
<div>
    <label class="block text-sm font-semibold mb-1">Trạng thái</label>
    <select name="trang_thai" class="w-full rounded-xl border-slate-300">
        <option value="1" @selected(old('trang_thai', $dichVu->trang_thai ?? 1) == 1)>Hiển thị</option>
        <option value="0" @selected(old('trang_thai', $dichVu->trang_thai ?? 1) == 0)>Ẩn</option>
    </select>
</div>
<div class="flex justify-end gap-3 pt-4">
    <a href="{{ route('admin.dich-vu.index') }}" class="px-4 py-2 rounded-xl border">Quay lại</a>
    <button class="px-5 py-2 rounded-xl bg-slate-900 text-white">Lưu</button>
</div>
