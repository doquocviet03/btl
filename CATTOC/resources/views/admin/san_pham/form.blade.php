{{-- UI NOTE: Form sản phẩm. Nếu muốn upload ảnh thật, đổi field hinh_anh từ text sang file và xử lý trong SanPhamController. --}}
<div class="grid lg:grid-cols-2 gap-5">
    <div><label class="bh-label">Tên sản phẩm</label><input name="ten_san_pham" value="{{ old('ten_san_pham', $sanPham->ten_san_pham) }}" class="bh-input" required></div>
    <div><label class="bh-label">Slug</label><input name="slug" value="{{ old('slug', $sanPham->slug) }}" class="bh-input" placeholder="Tự tạo nếu để trống"></div>
    <div><label class="bh-label">Thương hiệu</label><input name="thuong_hieu" value="{{ old('thuong_hieu', $sanPham->thuong_hieu) }}" class="bh-input"></div>
    <div><label class="bh-label">Loại sản phẩm</label><select name="loai_san_pham" class="bh-input" required><option value="cham_soc_toc" @selected(old('loai_san_pham', $sanPham->loai_san_pham ?: 'cham_soc_toc')==='cham_soc_toc')>Chăm sóc tóc</option><option value="cham_soc_da_dau" @selected(old('loai_san_pham', $sanPham->loai_san_pham)==='cham_soc_da_dau')>Chăm sóc da đầu</option><option value="tao_kieu" @selected(old('loai_san_pham', $sanPham->loai_san_pham)==='tao_kieu')>Tạo kiểu</option><option value="combo" @selected(old('loai_san_pham', $sanPham->loai_san_pham)==='combo')>Combo</option></select></div>
    <div><label class="bh-label">Giá gốc</label><input type="number" min="0" name="gia" value="{{ old('gia', $sanPham->gia ?? 0) }}" class="bh-input" required></div>
    <div><label class="bh-label">Giá khuyến mãi</label><input type="number" min="0" name="gia_khuyen_mai" value="{{ old('gia_khuyen_mai', $sanPham->gia_khuyen_mai) }}" class="bh-input"></div>
    <div><label class="bh-label">Số lượng tồn</label><input type="number" min="0" name="so_luong_ton" value="{{ old('so_luong_ton', $sanPham->so_luong_ton ?? 0) }}" class="bh-input" required></div>
    <div><label class="bh-label">Dung tích / quy cách</label><input name="dung_tich" value="{{ old('dung_tich', $sanPham->dung_tich) }}" class="bh-input"></div>
    <div class="lg:col-span-2"><label class="bh-label">Link hình ảnh</label><input name="hinh_anh" value="{{ old('hinh_anh', $sanPham->hinh_anh) }}" class="bh-input"></div>
    <div class="lg:col-span-2"><label class="bh-label">Mô tả ngắn</label><textarea name="mo_ta_ngan" rows="3" class="bh-input">{{ old('mo_ta_ngan', $sanPham->mo_ta_ngan) }}</textarea></div>
    <div class="lg:col-span-2"><label class="bh-label">Mô tả chi tiết</label><textarea name="mo_ta_chi_tiet" rows="6" class="bh-input">{{ old('mo_ta_chi_tiet', $sanPham->mo_ta_chi_tiet) }}</textarea></div>
    <label class="flex items-center gap-3 rounded-2xl border border-slate-200 p-4 font-black"><input type="checkbox" name="noi_bat" value="1" @checked(old('noi_bat', $sanPham->noi_bat)) class="rounded border-slate-300 text-orange-500 focus:ring-orange-500"> Sản phẩm nổi bật</label>
    <label class="flex items-center gap-3 rounded-2xl border border-slate-200 p-4 font-black"><input type="checkbox" name="trang_thai" value="1" @checked(old('trang_thai', $sanPham->trang_thai ?? true)) class="rounded border-slate-300 text-orange-500 focus:ring-orange-500"> Đang bán</label>
</div>
