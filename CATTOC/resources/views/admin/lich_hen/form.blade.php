@extends('admin.layouts.app')

@section('title', isset($lichHen) ? 'Sửa lịch hẹn' : 'Thêm lịch hẹn')
@section('page_title', isset($lichHen) ? 'Sửa lịch hẹn' : 'Thêm lịch hẹn')

@section('content')

<div class="bg-white dark:bg-gray-800 rounded-xl shadow p-5 max-w-4xl">

    <form method="POST"
          action="{{ isset($lichHen) ? route('admin.lich-hen.update', $lichHen->id) : route('admin.lich-hen.store') }}"
          class="space-y-5">

        @csrf

        @if(isset($lichHen))
            @method('PUT')
        @endif

        <div>
            <label class="block mb-2 font-medium">Khách hàng</label>

            <select name="khach_hang_id" class="w-full border rounded-lg px-4 py-2 dark:bg-gray-900">
                <option value="">-- Chọn khách hàng --</option>
                @foreach($khachHang as $kh)
                    <option value="{{ $kh->id }}"
                        @selected(old('khach_hang_id', $lichHen->khach_hang_id ?? '') == $kh->id)>
                        {{ $kh->ho_ten }} - {{ $kh->so_dien_thoai }}
                    </option>
                @endforeach
            </select>

            @error('khach_hang_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block mb-2 font-medium">Thợ cắt tóc</label>

            <select name="tho_id" class="w-full border rounded-lg px-4 py-2 dark:bg-gray-900">
                <option value="">-- Chọn thợ --</option>
                @foreach($thoCatToc as $tho)
                    <option value="{{ $tho->id }}"
                        @selected(old('tho_id', $lichHen->tho_id ?? '') == $tho->id)>
                        {{ $tho->ho_ten }} - {{ $tho->chuyen_mon }}
                    </option>
                @endforeach
            </select>

            @error('tho_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block mb-2 font-medium">Dịch vụ</label>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                @foreach($dichVu as $dv)
                    <label class="border rounded-lg p-3 flex items-center gap-3 dark:border-gray-700">
                        <input type="checkbox"
                               name="dich_vu_ids[]"
                               value="{{ $dv->id }}"
                               @checked(in_array($dv->id, old('dich_vu_ids', $selectedDichVu ?? [])))>

                        <span>
                            {{ $dv->ten_dich_vu }}
                            <br>
                            <small class="text-gray-500">
                                {{ number_format($dv->gia) }}đ - {{ $dv->thoi_gian }} phút
                            </small>
                        </span>
                    </label>
                @endforeach
            </div>

            @error('dich_vu_ids')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block mb-2 font-medium">Ngày hẹn</label>

                <input type="date"
                       name="ngay_hen"
                       value="{{ old('ngay_hen', isset($lichHen) ? $lichHen->ngay_hen->format('Y-m-d') : '') }}"
                       class="w-full border rounded-lg px-4 py-2 dark:bg-gray-900">

                @error('ngay_hen')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block mb-2 font-medium">Giờ bắt đầu</label>

                <input type="time"
                       name="gio_bat_dau"
                       value="{{ old('gio_bat_dau', isset($lichHen) ? substr($lichHen->gio_bat_dau, 0, 5) : '') }}"
                       class="w-full border rounded-lg px-4 py-2 dark:bg-gray-900">

                @error('gio_bat_dau')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label class="block mb-2 font-medium">Trạng thái</label>

            <select name="trang_thai" class="w-full border rounded-lg px-4 py-2 dark:bg-gray-900">
                @php
                    $statuses = [
                        'cho_xac_nhan' => 'Chờ xác nhận',
                        'da_xac_nhan' => 'Đã xác nhận',
                        'dang_thuc_hien' => 'Đang thực hiện',
                        'hoan_thanh' => 'Hoàn thành',
                        'da_huy' => 'Hủy lịch',
                    ];
                @endphp

                @foreach($statuses as $value => $label)
                    <option value="{{ $value }}"
                        @selected(old('trang_thai', $lichHen->trang_thai ?? 'cho_xac_nhan') == $value)>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block mb-2 font-medium">Ghi chú</label>

            <textarea name="ghi_chu"
                      rows="4"
                      class="w-full border rounded-lg px-4 py-2 dark:bg-gray-900">{{ old('ghi_chu', $lichHen->ghi_chu ?? '') }}</textarea>
        </div>

        <div class="flex gap-3">
            <button class="px-5 py-2 bg-black text-white rounded-lg">
                {{ isset($lichHen) ? 'Cập nhật' : 'Thêm lịch hẹn' }}
            </button>

            <a href="{{ route('admin.lich-hen.index') }}"
               class="px-5 py-2 bg-gray-200 dark:bg-gray-700 rounded-lg">
                Quay lại
            </a>
        </div>

    </form>

</div>

@endsection