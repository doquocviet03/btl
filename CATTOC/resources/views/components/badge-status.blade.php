@props(['status'])

@php
    // UI NOTE: Map trạng thái enum -> tiếng Việt. Nếu thêm status mới, chỉ cần bổ sung ở đây để không hiện xxx_xxx.
    $normalized = is_bool($status) ? ($status ? 'hoat_dong' : 'tam_khoa') : (string) $status;

    $classes = [
        'cho_xac_nhan' => 'bg-amber-100 text-amber-800',
        'da_xac_nhan' => 'bg-blue-100 text-blue-800',
        'dang_thuc_hien' => 'bg-purple-100 text-purple-800',
        'hoan_thanh' => 'bg-emerald-100 text-emerald-800',
        'da_huy' => 'bg-red-100 text-red-800',
        'dang_chuan_bi' => 'bg-indigo-100 text-indigo-800',
        'dang_giao' => 'bg-cyan-100 text-cyan-800',
        'da_thanh_toan' => 'bg-emerald-100 text-emerald-800',
        'chua_thanh_toan' => 'bg-amber-100 text-amber-800',
        'dang_cho_xac_nhan' => 'bg-fuchsia-100 text-fuchsia-800',
        'that_bai' => 'bg-red-100 text-red-800',
        'hoan_tien' => 'bg-slate-100 text-slate-800',
        'da_duyet' => 'bg-emerald-100 text-emerald-800',
        'cho_duyet' => 'bg-amber-100 text-amber-800',
        'an' => 'bg-slate-100 text-slate-800',
        'hoat_dong' => 'bg-emerald-100 text-emerald-800',
        'tam_khoa' => 'bg-red-100 text-red-800',
        'admin' => 'bg-slate-950 text-white',
        'khach_hang' => 'bg-orange-100 text-orange-800',
        'tho' => 'bg-blue-100 text-blue-800',
        'momo' => 'bg-fuchsia-100 text-fuchsia-800',
        'vnpay' => 'bg-blue-100 text-blue-800',
    ];

    $labels = [
        'cho_xac_nhan' => 'Chờ xác nhận',
        'da_xac_nhan' => 'Đã xác nhận',
        'dang_thuc_hien' => 'Đang thực hiện',
        'hoan_thanh' => 'Hoàn thành',
        'da_huy' => 'Đã hủy',
        'dang_chuan_bi' => 'Đang chuẩn bị',
        'dang_giao' => 'Đang giao',
        'da_thanh_toan' => 'Đã thanh toán',
        'chua_thanh_toan' => 'Chưa thanh toán',
        'dang_cho_xac_nhan' => 'Đang chờ xác nhận',
        'that_bai' => 'Thất bại',
        'hoan_tien' => 'Hoàn tiền',
        'da_duyet' => 'Đã duyệt',
        'cho_duyet' => 'Chờ duyệt',
        'an' => 'Ẩn',
        'hoat_dong' => 'Hoạt động',
        'tam_khoa' => 'Tạm khóa',
        'admin' => 'Quản trị',
        'khach_hang' => 'Khách hàng',
        'tho' => 'Thợ cắt tóc',
        'momo' => 'MoMo QR',
        'vnpay' => 'VNPAY',
    ];
@endphp

<span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-black {{ $classes[$normalized] ?? 'bg-slate-100 text-slate-700' }}">
    {{ $labels[$normalized] ?? \Illuminate\Support\Str::headline(str_replace('_', ' ', $normalized)) }}
</span>
