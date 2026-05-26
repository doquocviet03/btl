<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChiTietLichHen;
use App\Models\DichVu;
use App\Models\KhachHang;
use App\Models\LichHen;
use App\Models\LichLamViecTho;
use App\Models\ThoCatToc;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LichHenController extends Controller
{
    public function index()
    {
        $lichHen = LichHen::with(['khachHang', 'thoCatToc', 'chiTiet'])
            ->latest()
            ->paginate(10);

        return view('admin.lich_hen.index', compact('lichHen'));
    }

    public function create()
    {
        $khachHang = KhachHang::where('trang_thai', 1)->get();
        $thoCatToc = ThoCatToc::where('trang_thai', 1)->get();
        $dichVu = DichVu::where('trang_thai', 1)->get();

        return view('admin.lich_hen.form', compact('khachHang', 'thoCatToc', 'dichVu'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        $dichVuList = DichVu::whereIn('id', $data['dich_vu_ids'])->get();

        $tongTien = $dichVuList->sum('gia');
        $tongThoiGian = $dichVuList->sum('thoi_gian');

        $gioBatDau = Carbon::parse($data['gio_bat_dau']);
        $gioKetThuc = $gioBatDau->copy()->addMinutes($tongThoiGian);

        $this->kiemTraLichLamViec($data['tho_id'], $data['ngay_hen'], $gioBatDau, $gioKetThuc);
        $this->kiemTraTrungLich($data['tho_id'], $data['ngay_hen'], $gioBatDau, $gioKetThuc);

        DB::transaction(function () use ($data, $dichVuList, $tongTien, $gioBatDau, $gioKetThuc) {
            $lichHen = LichHen::create([
                'ma_lich_hen' => $this->makeAppointmentCode(),
                'khach_hang_id' => $data['khach_hang_id'],
                'tho_id' => $data['tho_id'],
                'ngay_hen' => $data['ngay_hen'],
                'gio_bat_dau' => $gioBatDau->format('H:i:s'),
                'gio_ket_thuc' => $gioKetThuc->format('H:i:s'),
                'tong_tien' => $tongTien,
                'trang_thai' => $data['trang_thai'],
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

            \App\Models\ThanhToan::create([
                'lich_hen_id' => $lichHen->id,
                'ma_thanh_toan' => $this->makePaymentCode(),
                'so_tien' => $tongTien,
                'phuong_thuc' => 'tien_mat',
                'trang_thai' => 'chua_thanh_toan',
            ]);
        });

        return redirect()
            ->route('admin.lich-hen.index')
            ->with('success', 'Thêm lịch hẹn thành công');
    }

    public function edit(LichHen $lichHen)
    {
        $lichHen->load('chiTiet');

        $khachHang = KhachHang::where('trang_thai', 1)->get();
        $thoCatToc = ThoCatToc::where('trang_thai', 1)->get();
        $dichVu = DichVu::where('trang_thai', 1)->get();

        $selectedDichVu = $lichHen->chiTiet->pluck('dich_vu_id')->toArray();

        return view('admin.lich_hen.form', compact(
            'lichHen',
            'khachHang',
            'thoCatToc',
            'dichVu',
            'selectedDichVu'
        ));
    }

    public function update(Request $request, LichHen $lichHen)
    {
        $data = $this->validateData($request);

        $dichVuList = DichVu::whereIn('id', $data['dich_vu_ids'])->get();

        $tongTien = $dichVuList->sum('gia');
        $tongThoiGian = $dichVuList->sum('thoi_gian');

        $gioBatDau = Carbon::parse($data['gio_bat_dau']);
        $gioKetThuc = $gioBatDau->copy()->addMinutes($tongThoiGian);

        $this->kiemTraLichLamViec($data['tho_id'], $data['ngay_hen'], $gioBatDau, $gioKetThuc);
        $this->kiemTraTrungLich($data['tho_id'], $data['ngay_hen'], $gioBatDau, $gioKetThuc, $lichHen->id);

        DB::transaction(function () use ($lichHen, $data, $dichVuList, $tongTien, $gioBatDau, $gioKetThuc) {
            $lichHen->update([
                'khach_hang_id' => $data['khach_hang_id'],
                'tho_id' => $data['tho_id'],
                'ngay_hen' => $data['ngay_hen'],
                'gio_bat_dau' => $gioBatDau->format('H:i:s'),
                'gio_ket_thuc' => $gioKetThuc->format('H:i:s'),
                'tong_tien' => $tongTien,
                'trang_thai' => $data['trang_thai'],
                'ghi_chu' => $data['ghi_chu'] ?? null,
            ]);

            $lichHen->chiTiet()->delete();

            foreach ($dichVuList as $dv) {
                ChiTietLichHen::create([
                    'lich_hen_id' => $lichHen->id,
                    'dich_vu_id' => $dv->id,
                    'ten_dich_vu' => $dv->ten_dich_vu,
                    'gia' => $dv->gia,
                    'thoi_gian' => $dv->thoi_gian,
                ]);
            }

            \App\Models\ThanhToan::updateOrCreate(
                ['lich_hen_id' => $lichHen->id],
                [
                    'ma_thanh_toan' => $lichHen->thanhToan->ma_thanh_toan ?? $this->makePaymentCode(),
                    'so_tien' => $tongTien,
                    'phuong_thuc' => $lichHen->thanhToan->phuong_thuc ?? 'tien_mat',
                    'trang_thai' => $lichHen->thanhToan->trang_thai ?? 'chua_thanh_toan',
                ]
            );
        });

        return redirect()
            ->route('admin.lich-hen.index')
            ->with('success', 'Cập nhật lịch hẹn thành công');
    }

    public function destroy(LichHen $lichHen)
    {
        $lichHen->delete();

        return redirect()
            ->back()
            ->with('success', 'Xóa lịch hẹn thành công');
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
        } while (\App\Models\ThanhToan::where('ma_thanh_toan', $code)->exists());

        return $code;
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'khach_hang_id' => 'required|exists:khach_hang,id',
            'tho_id' => 'required|exists:tho_cat_toc,id',
            'dich_vu_ids' => 'required|array|min:1',
            'dich_vu_ids.*' => 'exists:dich_vu,id',
            'ngay_hen' => 'required|date|after_or_equal:today',
            'gio_bat_dau' => 'required',
            'trang_thai' => 'required|in:cho_xac_nhan,da_xac_nhan,dang_thuc_hien,hoan_thanh,da_huy',
            'ghi_chu' => 'nullable|max:1000',
        ], [
            'khach_hang_id.required' => 'Vui lòng chọn khách hàng',
            'tho_id.required' => 'Vui lòng chọn thợ cắt tóc',
            'dich_vu_ids.required' => 'Vui lòng chọn ít nhất một dịch vụ',
            'ngay_hen.after_or_equal' => 'Ngày hẹn không được nhỏ hơn hôm nay',
        ]);
    }

    private function kiemTraLichLamViec($thoId, $ngayHen, Carbon $gioBatDau, Carbon $gioKetThuc): void
    {
        $coLichLam = LichLamViecTho::where('tho_id', $thoId)
            ->where('ngay_lam', $ngayHen)
            ->where('trang_thai', 1)
            ->whereTime('gio_bat_dau', '<=', $gioBatDau->format('H:i:s'))
            ->whereTime('gio_ket_thuc', '>=', $gioKetThuc->format('H:i:s'))
            ->exists();

        if (!$coLichLam) {
            throw \Illuminate\Validation\ValidationException::withMessages([
            'gio_bat_dau' => 'Thợ không có lịch làm việc trong khung giờ này.',
        ]);
        }
    }

    private function kiemTraTrungLich($thoId, $ngayHen, Carbon $gioBatDau, Carbon $gioKetThuc, $ignoreId = null): void
    {
        $query = LichHen::where('tho_id', $thoId)
            ->where('ngay_hen', $ngayHen)
            ->whereNotIn('trang_thai', ['da_huy'])
            ->where(function ($q) use ($gioBatDau, $gioKetThuc) {
                $q->whereTime('gio_bat_dau', '<', $gioKetThuc->format('H:i:s'))
                  ->whereTime('gio_ket_thuc', '>', $gioBatDau->format('H:i:s'));
            });

        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }

        if ($query->exists()) {
            throw \Illuminate\Validation\ValidationException::withMessages([
            'gio_bat_dau' => 'Khung giờ này đã có lịch hẹn khác.',
        ]);
        }
    }
}