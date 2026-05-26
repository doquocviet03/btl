<?php

namespace App\Http\Controllers\PublicSite;

use App\Http\Controllers\Controller;
use App\Models\ChiTietLichHen;
use App\Models\DanhGia;
use App\Models\DichVu;
use App\Models\KhachHang;
use App\Models\LichHen;
use App\Models\LichLamViecTho;
use App\Models\ThanhToan;
use App\Models\ThoCatToc;
use App\Models\ThongBao;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class BookingController extends Controller
{
    public function home()
    {
        $dichVuNoiBat = DichVu::with('danhMuc')
            ->where('trang_thai', 1)
            ->latest()
            ->limit(6)
            ->get();

        $thoCatToc = ThoCatToc::withCount('lichHen')
            ->where('trang_thai', 1)
            ->orderByDesc('kinh_nghiem')
            ->limit(4)
            ->get();

        $danhGiaMoi = DanhGia::with(['khachHang', 'tho'])
            ->where('trang_thai', 'da_duyet')
            ->latest()
            ->limit(6)
            ->get();

        $sanPhamNoiBat = \App\Models\SanPham::where('trang_thai', 1)
            ->orderByDesc('noi_bat')
            ->latest()
            ->limit(4)
            ->get();

        $baiVietMoi = \App\Models\BaiViet::where('trang_thai', 1)
            ->latest('xuat_ban_luc')
            ->limit(3)
            ->get();

        $soCuaHang = \App\Models\CuaHang::where('trang_thai', 1)->count();

        return view('user.home.index', compact('dichVuNoiBat', 'thoCatToc', 'danhGiaMoi', 'sanPhamNoiBat', 'baiVietMoi', 'soCuaHang'));
    }

    public function services(Request $request)
    {
        $dichVu = DichVu::with('danhMuc')
            ->where('trang_thai', 1)
            ->when($request->q, fn ($q) => $q->where('ten_dich_vu', 'like', '%' . $request->q . '%'))
            ->when($request->danh_muc_id, fn ($q) => $q->where('danh_muc_id', $request->danh_muc_id))
            ->orderBy('ten_dich_vu')
            ->paginate(9)
            ->withQueryString();

        $danhMuc = \App\Models\DanhMucDichVu::where('trang_thai', 1)
            ->orderBy('ten_danh_muc')
            ->get();

        return view('user.services.index', compact('dichVu', 'danhMuc'));
    }

    public function serviceShow(DichVu $dichVu)
    {
        abort_if(! $dichVu->trang_thai, 404);
        $dichVu->load('danhMuc');

        $lienQuan = DichVu::where('trang_thai', 1)
            ->where('id', '!=', $dichVu->id)
            ->when($dichVu->danh_muc_id, fn ($q) => $q->where('danh_muc_id', $dichVu->danh_muc_id))
            ->limit(3)
            ->get();

        return view('user.services.show', compact('dichVu', 'lienQuan'));
    }

    public function barbers(Request $request)
    {
        $thoCatToc = ThoCatToc::withCount('lichHen')
            ->where('trang_thai', 1)
            ->when($request->q, fn ($q) => $q->where(function ($sub) use ($request) {
                $sub->where('ho_ten', 'like', '%' . $request->q . '%')
                    ->orWhere('chuyen_mon', 'like', '%' . $request->q . '%');
            }))
            ->orderByDesc('kinh_nghiem')
            ->paginate(8)
            ->withQueryString();

        return view('user.barbers.index', compact('thoCatToc'));
    }

    public function barberShow(ThoCatToc $thoCatToc)
    {
        abort_if(! $thoCatToc->trang_thai, 404);

        $thoCatToc->load(['lichLamViec' => fn ($q) => $q
            ->whereDate('ngay_lam', '>=', today())
            ->where('trang_thai', 1)
            ->orderBy('ngay_lam')
            ->limit(10)
        ]);

        $danhGia = DanhGia::with('khachHang')
            ->where('tho_id', $thoCatToc->id)
            ->where('trang_thai', 'da_duyet')
            ->latest()
            ->paginate(6);

        return view('user.barbers.show', compact('thoCatToc', 'danhGia'));
    }

    public function index()
    {
        $dichVu = DichVu::where('trang_thai', 1)->orderBy('ten_dich_vu')->get();
        $thoCatToc = ThoCatToc::where('trang_thai', 1)->orderBy('ho_ten')->get();
        $khachHang = Auth::user()?->khachHang;

        return view('user.booking.index', compact('dichVu', 'thoCatToc', 'khachHang'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'ho_ten' => ['required', 'string', 'max:100'],
            'so_dien_thoai' => ['required', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:150'],
            'tho_id' => ['required', 'exists:tho_cat_toc,id'],
            'dich_vu_ids' => ['required', 'array', 'min:1'],
            'dich_vu_ids.*' => ['exists:dich_vu,id'],
            'ngay_hen' => ['required', 'date', 'after_or_equal:today'],
            'gio_bat_dau' => ['required', 'date_format:H:i'],
            'phuong_thuc' => ['required', Rule::in(['tien_mat', 'chuyen_khoan', 'vi_dien_tu', 'momo', 'vnpay'])],
            'ghi_chu' => ['nullable', 'string', 'max:1000'],
        ], [
            'dich_vu_ids.required' => 'Vui lòng chọn ít nhất một dịch vụ.',
            'ngay_hen.after_or_equal' => 'Ngày hẹn không được nhỏ hơn hôm nay.',
        ]);

        $dichVuList = DichVu::whereIn('id', $data['dich_vu_ids'])
            ->where('trang_thai', 1)
            ->get();

        if ($dichVuList->count() !== count($data['dich_vu_ids'])) {
            throw ValidationException::withMessages([
                'dich_vu_ids' => 'Một số dịch vụ đã ngừng hoạt động, vui lòng chọn lại.',
            ]);
        }

        $tongTien = $dichVuList->sum('gia');
        $tongThoiGian = $dichVuList->sum('thoi_gian');

        $gioBatDau = Carbon::createFromFormat('H:i', $data['gio_bat_dau']);
        $gioKetThuc = $gioBatDau->copy()->addMinutes($tongThoiGian);

        $this->kiemTraLichLamViec($data['tho_id'], $data['ngay_hen'], $gioBatDau, $gioKetThuc);
        $this->kiemTraTrungLich($data['tho_id'], $data['ngay_hen'], $gioBatDau, $gioKetThuc);

        $lichHen = DB::transaction(function () use ($data, $dichVuList, $tongTien, $gioBatDau, $gioKetThuc) {
            $khachHang = Auth::user()?->khachHang;

            if (! $khachHang) {
                $khachHang = KhachHang::firstOrCreate(
                    ['so_dien_thoai' => $data['so_dien_thoai']],
                    [
                        'ho_ten' => $data['ho_ten'],
                        'email' => $data['email'] ?? null,
                        'trang_thai' => 1,
                    ]
                );
            }

            $khachHang->update([
                'ho_ten' => $data['ho_ten'],
                'so_dien_thoai' => $data['so_dien_thoai'],
                'email' => $data['email'] ?? $khachHang->email,
                'trang_thai' => 1,
            ]);

            $lichHen = LichHen::create([
                'ma_lich_hen' => $this->makeAppointmentCode(),
                'khach_hang_id' => $khachHang->id,
                'tho_id' => $data['tho_id'],
                'ngay_hen' => $data['ngay_hen'],
                'gio_bat_dau' => $gioBatDau->format('H:i:s'),
                'gio_ket_thuc' => $gioKetThuc->format('H:i:s'),
                'tong_tien' => $tongTien,
                'trang_thai' => 'cho_xac_nhan',
                'ghi_chu' => $data['ghi_chu'] ?? null,
            ]);

            foreach ($dichVuList as $dv) {
                ChiTietLichHen::create([
                    'lich_hen_id' => $lichHen->id,
                    'dich_vu_id' => $dv->id,
                    'ten_dich_vu' => $dv->ten_dich_vu,
                    'gia' => $dv->gia,
                    'thoi_gian' => $dv->thoi_gian,
                ]);
            }

            ThanhToan::create([
                'lich_hen_id' => $lichHen->id,
                'ma_thanh_toan' => $this->makePaymentCode(),
                'so_tien' => $tongTien,
                'phuong_thuc' => $data['phuong_thuc'],
                'trang_thai' => 'chua_thanh_toan',
            ]);

            ThongBao::create([
                'tieu_de' => 'Có lịch hẹn mới',
                'noi_dung' => $khachHang->ho_ten . ' vừa đặt lịch ' . $lichHen->ma_lich_hen,
                'loai' => 'lich_hen',
                'lien_ket' => route('admin.lich-hen.edit', $lichHen->id, false),
                'da_doc' => 0,
            ]);

            return $lichHen;
        });

        return redirect()
            ->route('public.dat-lich.success', $lichHen)
            ->with('success', 'Đặt lịch thành công. Vui lòng chờ admin xác nhận.');
    }

    public function success(LichHen $lichHen)
    {
        $lichHen->load(['khachHang', 'tho', 'chiTiet', 'thanhToan']);

        return view('user.booking.success', compact('lichHen'));
    }

    public function myBookings()
    {
        $khachHang = Auth::user()?->khachHang;
        abort_if(! $khachHang, 404);

        $lichHen = LichHen::with(['tho', 'chiTiet', 'thanhToan', 'danhGia'])
            ->where('khach_hang_id', $khachHang->id)
            ->latest()
            ->paginate(10);

        return view('user.booking.my-bookings', compact('lichHen'));
    }

    public function cancel(Request $request, LichHen $lichHen)
    {
        $this->ensureOwner($lichHen);

        if (! in_array($lichHen->trang_thai, ['cho_xac_nhan', 'da_xac_nhan'])) {
            return back()->with('error', 'Chỉ có thể hủy lịch đang chờ xác nhận hoặc đã xác nhận.');
        }

        $data = $request->validate([
            'ly_do_huy' => ['nullable', 'string', 'max:1000'],
        ]);

        $lichHen->update([
            'trang_thai' => 'da_huy',
            'ly_do_huy' => $data['ly_do_huy'] ?? 'Khách hàng tự hủy lịch',
        ]);

        ThongBao::create([
            'tieu_de' => 'Khách hàng hủy lịch',
            'noi_dung' => ($lichHen->khachHang->ho_ten ?? 'Khách hàng') . ' đã hủy lịch ' . $lichHen->ma_lich_hen,
            'loai' => 'lich_hen',
            'lien_ket' => route('admin.lich-hen.edit', $lichHen->id, false),
            'da_doc' => 0,
        ]);

        return back()->with('success', 'Đã hủy lịch hẹn thành công.');
    }

    public function payment(LichHen $lichHen)
    {
        $this->ensureOwner($lichHen);
        $lichHen->load(['khachHang', 'tho', 'chiTiet', 'thanhToan']);

        return view('user.payment.index', compact('lichHen'));
    }

    public function paymentConfirm(Request $request, LichHen $lichHen)
    {
        $this->ensureOwner($lichHen);

        $data = $request->validate([
            'phuong_thuc' => ['required', Rule::in(['tien_mat', 'chuyen_khoan', 'vi_dien_tu', 'momo', 'vnpay'])],
            'ghi_chu' => ['nullable', 'string', 'max:1000'],
        ]);

        $thanhToan = $lichHen->thanhToan ?: ThanhToan::create([
            'lich_hen_id' => $lichHen->id,
            'ma_thanh_toan' => $this->makePaymentCode(),
            'so_tien' => $lichHen->tong_tien ?? 0,
            'phuong_thuc' => $data['phuong_thuc'],
            'trang_thai' => 'chua_thanh_toan',
        ]);

        $thanhToan->update([
            'phuong_thuc' => $data['phuong_thuc'],
            'ghi_chu' => $data['ghi_chu'] ?? $thanhToan->ghi_chu,
        ]);

        ThongBao::create([
            'tieu_de' => 'Khách hàng cập nhật thanh toán',
            'noi_dung' => ($lichHen->khachHang->ho_ten ?? 'Khách hàng') . ' đã cập nhật thông tin thanh toán cho ' . $lichHen->ma_lich_hen,
            'loai' => 'thanh_toan',
            'lien_ket' => route('admin.thanh-toan.edit', $thanhToan->id, false),
            'da_doc' => 0,
        ]);

        return redirect()->route('public.thanh-toan.success', $lichHen)
            ->with('success', 'Đã gửi thông tin thanh toán. Admin sẽ kiểm tra và xác nhận.');
    }

    public function paymentSuccess(LichHen $lichHen)
    {
        $this->ensureOwner($lichHen);
        $lichHen->load(['khachHang', 'tho', 'chiTiet', 'thanhToan']);

        return view('user.payment.success', compact('lichHen'));
    }

    public function reviewCreate(LichHen $lichHen)
    {
        $this->ensureOwner($lichHen);
        $lichHen->load(['tho', 'chiTiet', 'danhGia']);

        if ($lichHen->trang_thai !== 'hoan_thanh') {
            return redirect()->route('public.lich-cua-toi')->with('error', 'Chỉ đánh giá được lịch đã hoàn thành.');
        }

        if ($lichHen->danhGia) {
            return redirect()->route('public.danh-gia.history')->with('error', 'Lịch hẹn này đã được đánh giá.');
        }

        return view('user.review.create', compact('lichHen'));
    }

    public function reviewStore(Request $request, LichHen $lichHen)
    {
        $this->ensureOwner($lichHen);

        if ($lichHen->trang_thai !== 'hoan_thanh') {
            return redirect()->route('public.lich-cua-toi')->with('error', 'Chỉ đánh giá được lịch đã hoàn thành.');
        }

        if ($lichHen->danhGia()->exists()) {
            return redirect()->route('public.danh-gia.history')->with('error', 'Lịch hẹn này đã được đánh giá.');
        }

        $data = $request->validate([
            'so_sao' => ['required', 'integer', 'min:1', 'max:5'],
            'noi_dung' => ['nullable', 'string', 'max:1500'],
        ]);

        DanhGia::create([
            'lich_hen_id' => $lichHen->id,
            'khach_hang_id' => $lichHen->khach_hang_id,
            'tho_id' => $lichHen->tho_id,
            'so_sao' => $data['so_sao'],
            'noi_dung' => $data['noi_dung'] ?? null,
            'trang_thai' => 'cho_duyet',
        ]);

        ThongBao::create([
            'tieu_de' => 'Có đánh giá mới',
            'noi_dung' => ($lichHen->khachHang->ho_ten ?? 'Khách hàng') . ' vừa gửi đánh giá cho lịch ' . $lichHen->ma_lich_hen,
            'loai' => 'danh_gia',
            'lien_ket' => route('admin.danh-gia.index', [], false),
            'da_doc' => 0,
        ]);

        return redirect()->route('public.danh-gia.history')->with('success', 'Cảm ơn bạn đã đánh giá. Đánh giá sẽ hiển thị sau khi admin duyệt.');
    }

    public function reviewHistory()
    {
        $khachHang = Auth::user()?->khachHang;
        abort_if(! $khachHang, 404);

        $danhGia = DanhGia::with(['lichHen', 'tho'])
            ->where('khach_hang_id', $khachHang->id)
            ->latest()
            ->paginate(10);

        return view('user.review.history', compact('danhGia'));
    }

    private function ensureOwner(LichHen $lichHen): void
    {
        $khachHang = Auth::user()?->khachHang;
        abort_if(! $khachHang || $lichHen->khach_hang_id !== $khachHang->id, 403);
    }

    private function makeAppointmentCode(): string
    {
        do {
            $code = 'LH' . now()->format('ymdHis') . Str::upper(Str::random(4));
        } while (LichHen::where('ma_lich_hen', $code)->exists());

        return $code;
    }

    private function makePaymentCode(): string
    {
        do {
            $code = 'TT' . now()->format('ymdHis') . Str::upper(Str::random(4));
        } while (ThanhToan::where('ma_thanh_toan', $code)->exists());

        return $code;
    }

    private function kiemTraLichLamViec($thoId, $ngayHen, Carbon $gioBatDau, Carbon $gioKetThuc): void
    {
        $coLichLam = LichLamViecTho::where('tho_id', $thoId)
            ->where('ngay_lam', $ngayHen)
            ->where('trang_thai', 1)
            ->whereTime('gio_bat_dau', '<=', $gioBatDau->format('H:i:s'))
            ->whereTime('gio_ket_thuc', '>=', $gioKetThuc->format('H:i:s'))
            ->exists();

        if (! $coLichLam) {
            throw ValidationException::withMessages([
                'gio_bat_dau' => 'Thợ không có lịch làm việc trong khung giờ này.',
            ]);
        }
    }

    private function kiemTraTrungLich($thoId, $ngayHen, Carbon $gioBatDau, Carbon $gioKetThuc): void
    {
        $exists = LichHen::where('tho_id', $thoId)
            ->where('ngay_hen', $ngayHen)
            ->whereNotIn('trang_thai', ['da_huy'])
            ->where(function ($q) use ($gioBatDau, $gioKetThuc) {
                $q->whereTime('gio_bat_dau', '<', $gioKetThuc->format('H:i:s'))
                    ->whereTime('gio_ket_thuc', '>', $gioBatDau->format('H:i:s'));
            })
            ->exists();

        if ($exists) {
            throw ValidationException::withMessages([
                'gio_bat_dau' => 'Khung giờ này đã có lịch hẹn khác.',
            ]);
        }
    }
}
