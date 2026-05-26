<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LichHen;
use App\Models\ThanhToan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ThanhToanController extends Controller
{
    public function index(Request $request)
    {
        $query = ThanhToan::with(['lichHen.khachHang', 'lichHen.tho']);

        if ($request->filled('q')) {
            $keyword = trim($request->q);
            $query->where(function ($q) use ($keyword) {
                $q->where('ma_thanh_toan', 'like', "%{$keyword}%")
                    ->orWhereHas('lichHen', function ($lichHen) use ($keyword) {
                        $lichHen->where('ma_lich_hen', 'like', "%{$keyword}%")
                            ->orWhereHas('khachHang', function ($khachHang) use ($keyword) {
                                $khachHang->where('ho_ten', 'like', "%{$keyword}%")
                                    ->orWhere('so_dien_thoai', 'like', "%{$keyword}%");
                            });
                    });
            });
        }

        if ($request->filled('trang_thai')) {
            $query->where('trang_thai', $request->trang_thai);
        }

        if ($request->filled('phuong_thuc')) {
            $query->where('phuong_thuc', $request->phuong_thuc);
        }

        $tongDaThanhToan = (clone $query)->where('trang_thai', 'da_thanh_toan')->sum('so_tien');
        $tongChuaThanhToan = (clone $query)->where('trang_thai', 'chua_thanh_toan')->sum('so_tien');

        $thanhToan = $query->latest()->paginate(10)->withQueryString();

        return view('admin.thanh_toan.index', compact('thanhToan', 'tongDaThanhToan', 'tongChuaThanhToan'));
    }

    public function edit(ThanhToan $thanhToan)
    {
        $thanhToan->load(['lichHen.khachHang', 'lichHen.tho']);

        return view('admin.thanh_toan.edit', compact('thanhToan'));
    }

    public function update(Request $request, ThanhToan $thanhToan)
    {
        $data = $request->validate([
            'so_tien' => ['required', 'numeric', 'min:0'],
            'phuong_thuc' => ['required', 'in:tien_mat,chuyen_khoan,vi_dien_tu,momo,vnpay'],
            'trang_thai' => ['required', 'in:chua_thanh_toan,da_thanh_toan,that_bai,hoan_tien'],
            'ngay_thanh_toan' => ['nullable', 'date'],
            'ghi_chu' => ['nullable', 'string', 'max:1000'],
        ]);

        if ($data['trang_thai'] === 'da_thanh_toan' && empty($data['ngay_thanh_toan'])) {
            $data['ngay_thanh_toan'] = now();
        }

        if ($data['trang_thai'] !== 'da_thanh_toan') {
            $data['ngay_thanh_toan'] = null;
        }

        $thanhToan->update($data);

        if ($data['trang_thai'] === 'da_thanh_toan') {
            $thanhToan->lichHen?->update(['trang_thai' => 'hoan_thanh']);
        }

        return redirect()->route('admin.thanh-toan.index')->with('success', 'Cập nhật thanh toán thành công.');
    }

    public function destroy(ThanhToan $thanhToan)
    {
        $thanhToan->delete();

        return redirect()->route('admin.thanh-toan.index')->with('success', 'Đã xóa thanh toán.');
    }

    public function createForAppointment(LichHen $lichHen)
    {
        $thanhToan = ThanhToan::firstOrCreate(
            ['lich_hen_id' => $lichHen->id],
            [
                'ma_thanh_toan' => 'TT' . now()->format('YmdHis') . strtoupper(Str::random(4)),
                'so_tien' => $lichHen->tong_tien ?? 0,
                'phuong_thuc' => 'tien_mat',
                'trang_thai' => 'chua_thanh_toan',
            ]
        );

        return redirect()->route('admin.thanh-toan.edit', $thanhToan)->with('success', 'Đã tạo phiếu thanh toán cho lịch hẹn.');
    }

    public function markPaid(Request $request, ThanhToan $thanhToan)
    {
        $data = $request->validate([
            'phuong_thuc' => ['required', 'in:tien_mat,chuyen_khoan,vi_dien_tu,momo,vnpay'],
            'ghi_chu' => ['nullable', 'string', 'max:1000'],
        ]);

        $thanhToan->update([
            'phuong_thuc' => $data['phuong_thuc'],
            'trang_thai' => 'da_thanh_toan',
            'ngay_thanh_toan' => now(),
            'ghi_chu' => $data['ghi_chu'] ?? $thanhToan->ghi_chu,
        ]);

        $thanhToan->lichHen?->update([
            'trang_thai' => 'hoan_thanh',
        ]);

        return back()->with('success', 'Đã xác nhận thanh toán thành công.');
    }

    public function invoice(LichHen $lichHen)
    {
        $lichHen->load(['khachHang', 'tho', 'chiTiet', 'thanhToan']);

        if (! $lichHen->thanhToan) {
            ThanhToan::create([
                'lich_hen_id' => $lichHen->id,
                'ma_thanh_toan' => 'TT' . now()->format('YmdHis') . strtoupper(Str::random(4)),
                'so_tien' => $lichHen->tong_tien ?? 0,
                'phuong_thuc' => 'tien_mat',
                'trang_thai' => 'chua_thanh_toan',
            ]);

            $lichHen->refresh()->load(['khachHang', 'tho', 'chiTiet', 'thanhToan']);
        }

        return view('admin.thanh_toan.invoice', compact('lichHen'));
    }
}
