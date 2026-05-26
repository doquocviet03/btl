<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LichLamViecTho;
use App\Models\ThoCatToc;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LichLamViecThangController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->month ?? now()->format('Y-m');
        $selectedDate = $request->date ?? Carbon::createFromFormat('Y-m', $month)->startOfMonth()->format('Y-m-d');

        $date = Carbon::parse($selectedDate);

        $thoCatToc = ThoCatToc::where('trang_thai', 1)
            ->orderBy('id')
            ->get();

        $lichLamViec = LichLamViecTho::where('ngay_lam', $date->format('Y-m-d'))
            ->get()
            ->keyBy('tho_id');

        return view('admin.lich_lam_viec_thang.index', compact(
            'month',
            'date',
            'thoCatToc',
            'lichLamViec'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'month' => 'required',
            'date' => 'required|date',
            'lich' => 'required|array',
        ]);

        foreach ($request->lich as $thoId => $data) {
            $caLam = $data['ca_lam'] ?? 'nghi';
            $ghiChu = $data['ghi_chu'] ?? null;

            $time = $this->getTimeByCaLam($caLam);

            LichLamViecTho::updateOrCreate(
                [
                    'tho_id' => $thoId,
                    'ngay_lam' => $request->date,
                ],
                [
                    'ca_lam' => $time['ca_lam'],
                    'gio_bat_dau' => $time['gio_bat_dau'],
                    'gio_ket_thuc' => $time['gio_ket_thuc'],
                    'trang_thai' => $time['trang_thai'],
                    'ghi_chu' => $ghiChu,
                ]
            );
        }

        return redirect()
            ->route('admin.lich-lam-viec-thang.index', [
                'month' => $request->month,
                'date' => $request->date,
            ])
            ->with('success', 'Cập nhật lịch làm việc thành công');
    }

    private function getTimeByCaLam(string $caLam): array
    {
        return match ($caLam) {
            'sang' => [
                'ca_lam' => 'sang',
                'gio_bat_dau' => '08:00:00',
                'gio_ket_thuc' => '12:00:00',
                'trang_thai' => 1,
            ],
            'chieu' => [
                'ca_lam' => 'chieu',
                'gio_bat_dau' => '13:00:00',
                'gio_ket_thuc' => '18:00:00',
                'trang_thai' => 1,
            ],
            'ca_ngay' => [
                'ca_lam' => 'ca_ngay',
                'gio_bat_dau' => '08:00:00',
                'gio_ket_thuc' => '18:00:00',
                'trang_thai' => 1,
            ],
            default => [
                'ca_lam' => 'ca_ngay',
                'gio_bat_dau' => '00:00:00',
                'gio_ket_thuc' => '00:00:00',
                'trang_thai' => 0,
            ],
        };
    }
}