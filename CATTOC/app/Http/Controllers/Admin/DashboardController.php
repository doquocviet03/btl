<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DichVu;
use App\Models\KhachHang;
use App\Models\LichHen;
use App\Models\ThanhToan;
use App\Models\ThoCatToc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $year = (int) $request->input('year', now()->year);
        $month = $request->filled('month') ? (int) $request->month : null;
        $from = $request->input('from');
        $to = $request->input('to');

        $paymentFilter = ThanhToan::query()
            ->where('trang_thai', 'da_thanh_toan')
            ->when($year, fn ($q) => $q->whereYear('ngay_thanh_toan', $year))
            ->when($month, fn ($q) => $q->whereMonth('ngay_thanh_toan', $month))
            ->when($from, fn ($q) => $q->whereDate('ngay_thanh_toan', '>=', $from))
            ->when($to, fn ($q) => $q->whereDate('ngay_thanh_toan', '<=', $to));

        $tongKhachHang = KhachHang::count();
        $tongLichHen = LichHen::count();
        $tongDichVu = DichVu::count();
        $tongTho = ThoCatToc::count();
        $tongDoanhThu = (clone $paymentFilter)->sum('so_tien');

        $lichHomNay = LichHen::whereDate('ngay_hen', today())->count();

        $doanhThuTheoThang = ThanhToan::selectRaw('MONTH(ngay_thanh_toan) as thang, SUM(so_tien) as tong')
            ->where('trang_thai', 'da_thanh_toan')
            ->whereYear('ngay_thanh_toan', $year)
            ->whereNotNull('ngay_thanh_toan')
            ->groupBy('thang')
            ->orderBy('thang')
            ->pluck('tong', 'thang')
            ->toArray();

        $chartDoanhThuThang = [];

        for ($i = 1; $i <= 12; $i++) {
            $chartDoanhThuThang[] = (float) ($doanhThuTheoThang[$i] ?? 0);
        }

        $trangThaiLichHen = LichHen::select('trang_thai', DB::raw('COUNT(*) as tong'))
            ->groupBy('trang_thai')
            ->pluck('tong', 'trang_thai')
            ->toArray();

        $topDichVu = DB::table('chi_tiet_lich_hen')
            ->select('ten_dich_vu', DB::raw('COUNT(*) as tong'))
            ->groupBy('ten_dich_vu')
            ->orderByDesc('tong')
            ->limit(5)
            ->get();

        $topTho = LichHen::with('tho')
            ->select('tho_id', DB::raw('COUNT(*) as tong'))
            ->groupBy('tho_id')
            ->orderByDesc('tong')
            ->limit(5)
            ->get();

        $lichHenGanDay = LichHen::with(['khachHang', 'tho', 'thanhToan'])
            ->latest()
            ->limit(8)
            ->get();

        return view('admin.dashboard.index', compact(
            'year',
            'month',
            'from',
            'to',
            'tongKhachHang',
            'tongLichHen',
            'tongDichVu',
            'tongTho',
            'tongDoanhThu',
            'lichHomNay',
            'chartDoanhThuThang',
            'trangThaiLichHen',
            'topDichVu',
            'topTho',
            'lichHenGanDay'
        ));
    }
}