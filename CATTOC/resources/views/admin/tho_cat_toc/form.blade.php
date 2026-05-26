@csrf
<div class="grid md:grid-cols-2 gap-4">
    <div><label class="block text-sm font-semibold mb-1">Họ tên *</label><input name="ho_ten" value="{{ old('ho_ten', $thoCatToc->ho_ten ?? '') }}" class="w-full rounded-xl border-slate-300" required></div>
    <div><label class="block text-sm font-semibold mb-1">Số điện thoại</label><input name="so_dien_thoai" value="{{ old('so_dien_thoai', $thoCatToc->so_dien_thoai ?? '') }}" class="w-full rounded-xl border-slate-300"></div>
</div>
<div class="grid md:grid-cols-2 gap-4">
    <div><label class="block text-sm font-semibold mb-1">Email</label><input type="email" name="email" value="{{ old('email', $thoCatToc->email ?? '') }}" class="w-full rounded-xl border-slate-300"></div>
    <div><label class="block text-sm font-semibold mb-1">Kinh nghiệm/năm</label><input type="number" min="0" name="kinh_nghiem" value="{{ old('kinh_nghiem', $thoCatToc->kinh_nghiem ?? 0) }}" class="w-full rounded-xl border-slate-300"></div>
</div>
<div><label class="block text-sm font-semibold mb-1">Chuyên môn</label><input name="chuyen_mon" value="{{ old('chuyen_mon', $thoCatToc->chuyen_mon ?? '') }}" class="w-full rounded-xl border-slate-300"></div>
<div><label class="block text-sm font-semibold mb-1">Link ảnh đại diện</label><input name="anh_dai_dien" value="{{ old('anh_dai_dien', $thoCatToc->anh_dai_dien ?? '') }}" class="w-full rounded-xl border-slate-300"></div>
<div><label class="block text-sm font-semibold mb-1">Mô tả</label><textarea name="mo_ta" rows="4" class="w-full rounded-xl border-slate-300">{{ old('mo_ta', $thoCatToc->mo_ta ?? '') }}</textarea></div>
<div><label class="block text-sm font-semibold mb-1">Trạng thái</label><select name="trang_thai" class="w-full rounded-xl border-slate-300"><option value="1" @selected(old('trang_thai', $thoCatToc->trang_thai ?? 1)==1)>Đang làm</option><option value="0" @selected(old('trang_thai', $thoCatToc->trang_thai ?? 1)==0)>Nghỉ</option></select></div>
<div class="flex justify-end gap-3 pt-4"><a href="{{ route('admin.tho-cat-toc.index') }}" class="px-4 py-2 rounded-xl border">Quay lại</a><button class="px-5 py-2 rounded-xl bg-slate-900 text-white">Lưu</button></div>
