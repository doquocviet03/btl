@csrf
<div class="grid md:grid-cols-2 gap-4">
    <div><label class="block text-sm font-semibold mb-1">Họ tên *</label><input name="ho_ten" value="{{ old('ho_ten', $taiKhoan->ho_ten ?? '') }}" class="w-full rounded-xl border-slate-300" required></div>
    <div><label class="block text-sm font-semibold mb-1">Email *</label><input type="email" name="email" value="{{ old('email', $taiKhoan->email ?? '') }}" class="w-full rounded-xl border-slate-300" required></div>
</div>
<div class="grid md:grid-cols-2 gap-4">
    <div><label class="block text-sm font-semibold mb-1">Số điện thoại</label><input name="so_dien_thoai" value="{{ old('so_dien_thoai', $taiKhoan->so_dien_thoai ?? '') }}" class="w-full rounded-xl border-slate-300"></div>
    <div><label class="block text-sm font-semibold mb-1">Mật khẩu {{ isset($taiKhoan) ? '(bỏ trống nếu không đổi)' : '*' }}</label><input type="password" name="mat_khau" class="w-full rounded-xl border-slate-300" {{ isset($taiKhoan) ? '' : 'required' }}></div>
</div>
<div class="grid md:grid-cols-2 gap-4">
    <div><label class="block text-sm font-semibold mb-1">Vai trò</label><select name="vai_tro" class="w-full rounded-xl border-slate-300"><option value="admin" @selected(old('vai_tro', $taiKhoan->vai_tro ?? '')=='admin')>Admin</option><option value="khach_hang" @selected(old('vai_tro', $taiKhoan->vai_tro ?? 'khach_hang')=='khach_hang')>Khách hàng</option><option value="tho" @selected(old('vai_tro', $taiKhoan->vai_tro ?? '')=='tho')>Thợ</option></select></div>
    <div><label class="block text-sm font-semibold mb-1">Trạng thái</label><select name="trang_thai" class="w-full rounded-xl border-slate-300"><option value="1" @selected(old('trang_thai', $taiKhoan->trang_thai ?? 1)==1)>Hoạt động</option><option value="0" @selected(old('trang_thai', $taiKhoan->trang_thai ?? 1)==0)>Khóa</option></select></div>
</div>
<div class="flex justify-end gap-3 pt-4"><a href="{{ route('admin.tai-khoan.index') }}" class="px-4 py-2 rounded-xl border">Quay lại</a><button class="px-5 py-2 rounded-xl bg-slate-900 text-white">Lưu</button></div>
