@csrf
<div class="grid md:grid-cols-2 gap-4">
    <div><label class="block text-sm font-semibold mb-1">Họ tên *</label><input name="ho_ten" value="{{ old('ho_ten', $khachHang->ho_ten ?? '') }}" class="w-full rounded-xl border-slate-300" required></div>
    <div><label class="block text-sm font-semibold mb-1">Số điện thoại *</label><input name="so_dien_thoai" value="{{ old('so_dien_thoai', $khachHang->so_dien_thoai ?? '') }}" class="w-full rounded-xl border-slate-300" required></div>
</div>
<div class="grid md:grid-cols-2 gap-4">
    <div><label class="block text-sm font-semibold mb-1">Email</label><input type="email" name="email" value="{{ old('email', $khachHang->email ?? '') }}" class="w-full rounded-xl border-slate-300"></div>
    <div><label class="block text-sm font-semibold mb-1">Ngày sinh</label><input type="date" name="ngay_sinh" value="{{ old('ngay_sinh', $khachHang->ngay_sinh ?? '') }}" class="w-full rounded-xl border-slate-300"></div>
</div>
<div class="grid md:grid-cols-2 gap-4">
    <div><label class="block text-sm font-semibold mb-1">Giới tính</label><select name="gioi_tinh" class="w-full rounded-xl border-slate-300"><option value="">-- Chọn --</option><option value="nam" @selected(old('gioi_tinh', $khachHang->gioi_tinh ?? '')=='nam')>Nam</option><option value="nu" @selected(old('gioi_tinh', $khachHang->gioi_tinh ?? '')=='nu')>Nữ</option><option value="khac" @selected(old('gioi_tinh', $khachHang->gioi_tinh ?? '')=='khac')>Khác</option></select></div>
    <div><label class="block text-sm font-semibold mb-1">Trạng thái</label><select name="trang_thai" class="w-full rounded-xl border-slate-300"><option value="1" @selected(old('trang_thai', $khachHang->trang_thai ?? 1)==1)>Hoạt động</option><option value="0" @selected(old('trang_thai', $khachHang->trang_thai ?? 1)==0)>Khóa</option></select></div>
</div>
<div><label class="block text-sm font-semibold mb-1">Địa chỉ</label><input name="dia_chi" value="{{ old('dia_chi', $khachHang->dia_chi ?? '') }}" class="w-full rounded-xl border-slate-300"></div>
<div><label class="block text-sm font-semibold mb-1">Ghi chú</label><textarea name="ghi_chu" rows="4" class="w-full rounded-xl border-slate-300">{{ old('ghi_chu', $khachHang->ghi_chu ?? '') }}</textarea></div>
<div class="flex justify-end gap-3 pt-4"><a href="{{ route('admin.khach-hang.index') }}" class="px-4 py-2 rounded-xl border">Quay lại</a><button class="px-5 py-2 rounded-xl bg-slate-900 text-white">Lưu</button></div>
