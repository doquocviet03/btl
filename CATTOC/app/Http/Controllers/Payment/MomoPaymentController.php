<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\DonHang;
use App\Models\LichHen;
use App\Models\ThanhToan;
use App\Models\ThongBao;
use App\Services\MomoPaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class MomoPaymentController extends Controller
{
    public function __construct(private readonly MomoPaymentService $momoPaymentService)
    {
    }

    public function createForAppointment(LichHen $lichHen)
    {
        $this->ensureAppointmentOwner($lichHen);
        $lichHen->load(['khachHang', 'thanhToan']);

        $thanhToan = $lichHen->thanhToan ?: ThanhToan::create([
            'lich_hen_id' => $lichHen->id,
            'ma_thanh_toan' => $this->makePaymentCode(),
            'so_tien' => $lichHen->tong_tien,
            'phuong_thuc' => 'momo',
            'trang_thai' => 'chua_thanh_toan',
        ]);

        if ($thanhToan->trang_thai === 'da_thanh_toan') {
            return back()->with('success', 'Lịch hẹn này đã được thanh toán.');
        }

        if (! $this->momoPaymentService->isConfigured()) {
            $thanhToan->update([
                'phuong_thuc' => 'momo',
                'ghi_chu' => trim(($thanhToan->ghi_chu ? $thanhToan->ghi_chu . "\n" : '') . 'Khách chọn MoMo QR tĩnh. Admin cần kiểm tra giao dịch thủ công.'),
            ]);

            return back()->with('success', 'Đang dùng MoMo QR tĩnh. Vui lòng quét QR và nhập đúng nội dung chuyển khoản.');
        }

        $orderId = 'TT' . $thanhToan->id . '_' . now()->format('ymdHis') . '_' . Str::upper(Str::random(4));
        $requestId = $orderId;
        $amount = (int) round($thanhToan->so_tien);

        $result = $this->momoPaymentService->createPayment([
            'amount' => $amount,
            'order_id' => $orderId,
            'request_id' => $requestId,
            'order_info' => 'Thanh toán lịch hẹn ' . $lichHen->ma_lich_hen,
            'redirect_url' => route('momo.appointment.return', $lichHen),
            'ipn_url' => route('momo.ipn'),
            'extra_data' => base64_encode(json_encode([
                'type' => 'appointment',
                'lich_hen_id' => $lichHen->id,
                'thanh_toan_id' => $thanhToan->id,
            ], JSON_UNESCAPED_UNICODE)),
        ]);

        $response = $result['response'];
        $payUrl = $response['payUrl'] ?? null;

        $thanhToan->update([
            'phuong_thuc' => 'momo',
            'momo_order_id' => $orderId,
            'momo_request_id' => $requestId,
            'momo_pay_url' => $payUrl,
            'momo_deeplink' => $response['deeplink'] ?? null,
            'momo_qr_code' => $response['qrCodeUrl'] ?? null,
            'momo_result_code' => $response['resultCode'] ?? null,
            'momo_message' => $response['message'] ?? null,
            'momo_payload' => json_encode($result, JSON_UNESCAPED_UNICODE),
        ]);

        if (! $result['ok'] || ! $payUrl) {
            return back()->with('error', 'Không tạo được giao dịch MoMo. Kiểm tra thông tin MOMO_* trong file .env hoặc dùng QR tĩnh.');
        }

        return redirect()->away($payUrl);
    }

    public function appointmentReturn(Request $request, LichHen $lichHen)
    {
        $lichHen->load('thanhToan');
        $thanhToan = $lichHen->thanhToan;

        if ($thanhToan) {
            $this->syncMomoResult($request->all(), $thanhToan, null, false);
        }

        return redirect()->route('public.thanh-toan.index', $lichHen)
            ->with('success', 'Đã quay lại từ MoMo. Nếu giao dịch thành công, hệ thống sẽ cập nhật sau khi nhận IPN hoặc admin xác nhận.');
    }

    public function createForOrder(DonHang $donHang)
    {
        if ($donHang->trang_thai_thanh_toan === 'da_thanh_toan') {
            return back()->with('success', 'Đơn hàng này đã được thanh toán.');
        }

        if (! $this->momoPaymentService->isConfigured()) {
            $donHang->update([
                'phuong_thuc_thanh_toan' => 'momo',
                'ghi_chu' => trim(($donHang->ghi_chu ? $donHang->ghi_chu . "\n" : '') . 'Khách chọn MoMo QR tĩnh. Admin cần kiểm tra giao dịch thủ công.'),
            ]);

            return back()->with('success', 'Đang dùng MoMo QR tĩnh. Vui lòng quét QR và nhập đúng nội dung chuyển khoản.');
        }

        $orderId = 'DH' . $donHang->id . '_' . now()->format('ymdHis') . '_' . Str::upper(Str::random(4));
        $requestId = $orderId;
        $amount = (int) round($donHang->tong_tien);

        $result = $this->momoPaymentService->createPayment([
            'amount' => $amount,
            'order_id' => $orderId,
            'request_id' => $requestId,
            'order_info' => 'Thanh toán đơn hàng ' . $donHang->ma_don_hang,
            'redirect_url' => route('momo.order.return', $donHang),
            'ipn_url' => route('momo.ipn'),
            'extra_data' => base64_encode(json_encode([
                'type' => 'order',
                'don_hang_id' => $donHang->id,
            ], JSON_UNESCAPED_UNICODE)),
        ]);

        $response = $result['response'];
        $payUrl = $response['payUrl'] ?? null;

        $donHang->update([
            'phuong_thuc_thanh_toan' => 'momo',
            'trang_thai_thanh_toan' => 'chua_thanh_toan',
            'momo_order_id' => $orderId,
            'momo_request_id' => $requestId,
            'momo_pay_url' => $payUrl,
            'momo_deeplink' => $response['deeplink'] ?? null,
            'momo_qr_code' => $response['qrCodeUrl'] ?? null,
            'momo_result_code' => $response['resultCode'] ?? null,
            'momo_message' => $response['message'] ?? null,
            'momo_payload' => json_encode($result, JSON_UNESCAPED_UNICODE),
        ]);

        if (! $result['ok'] || ! $payUrl) {
            return back()->with('error', 'Không tạo được giao dịch MoMo. Kiểm tra thông tin MOMO_* trong file .env hoặc dùng QR tĩnh.');
        }

        return redirect()->away($payUrl);
    }

    public function orderReturn(Request $request, DonHang $donHang)
    {
        $this->syncMomoResult($request->all(), null, $donHang, false);

        return redirect()->route('public.gio-hang.thanh-cong', $donHang)
            ->with('success', 'Đã quay lại từ MoMo. Nếu giao dịch thành công, hệ thống sẽ cập nhật sau khi nhận IPN hoặc admin xác nhận.');
    }

    public function ipn(Request $request)
    {
        $payload = $request->all();

        if (! $this->momoPaymentService->verifyNotificationSignature($payload)) {
            Log::warning('MoMo IPN signature invalid', $payload);
            return response('', 204);
        }

        $orderId = $payload['orderId'] ?? null;

        DB::transaction(function () use ($payload, $orderId) {
            if ($thanhToan = ThanhToan::where('momo_order_id', $orderId)->lockForUpdate()->first()) {
                $this->syncMomoResult($payload, $thanhToan, null, true);
                return;
            }

            if ($donHang = DonHang::where('momo_order_id', $orderId)->lockForUpdate()->first()) {
                $this->syncMomoResult($payload, null, $donHang, true);
            }
        });

        return response('', 204);
    }

    private function syncMomoResult(array $payload, ?ThanhToan $thanhToan = null, ?DonHang $donHang = null, bool $trusted = false): void
    {
        $resultCode = isset($payload['resultCode']) ? (int) $payload['resultCode'] : null;
        $isSuccess = $trusted && $resultCode === 0;

        if ($thanhToan) {
            $update = [
                'momo_trans_id' => $payload['transId'] ?? $thanhToan->momo_trans_id,
                'momo_result_code' => $payload['resultCode'] ?? $thanhToan->momo_result_code,
                'momo_message' => $payload['message'] ?? $thanhToan->momo_message,
                'momo_payload' => json_encode($payload, JSON_UNESCAPED_UNICODE),
            ];

            if ($isSuccess && (int) round($thanhToan->so_tien) === (int) ($payload['amount'] ?? 0)) {
                $update['trang_thai'] = 'da_thanh_toan';
                $update['ngay_thanh_toan'] = now();
            } elseif ($trusted && $resultCode !== null && $resultCode !== 0) {
                $update['trang_thai'] = 'that_bai';
            }

            $thanhToan->update($update);

            if ($isSuccess) {
                ThongBao::create([
                    'tieu_de' => 'MoMo xác nhận thanh toán',
                    'noi_dung' => 'Giao dịch MoMo cho ' . ($thanhToan->lichHen->ma_lich_hen ?? $thanhToan->ma_thanh_toan) . ' đã thành công.',
                    'loai' => 'thanh_toan',
                    'lien_ket' => route('admin.thanh-toan.edit', $thanhToan->id, false),
                    'da_doc' => 0,
                ]);
            }
        }

        if ($donHang) {
            $update = [
                'momo_trans_id' => $payload['transId'] ?? $donHang->momo_trans_id,
                'momo_result_code' => $payload['resultCode'] ?? $donHang->momo_result_code,
                'momo_message' => $payload['message'] ?? $donHang->momo_message,
                'momo_payload' => json_encode($payload, JSON_UNESCAPED_UNICODE),
            ];

            if ($isSuccess && (int) round($donHang->tong_tien) === (int) ($payload['amount'] ?? 0)) {
                $update['trang_thai_thanh_toan'] = 'da_thanh_toan';
            } elseif ($trusted && $resultCode !== null && $resultCode !== 0) {
                $update['trang_thai_thanh_toan'] = 'that_bai';
            }

            $donHang->update($update);

            if ($isSuccess) {
                ThongBao::create([
                    'tieu_de' => 'MoMo xác nhận đơn hàng',
                    'noi_dung' => 'Đơn hàng ' . $donHang->ma_don_hang . ' đã thanh toán MoMo thành công.',
                    'loai' => 'don_hang',
                    'lien_ket' => route('admin.don-hang.edit', $donHang->id, false),
                    'da_doc' => 0,
                ]);
            }
        }
    }

    private function ensureAppointmentOwner(LichHen $lichHen): void
    {
        $khachHang = auth()->user()?->khachHang;
        abort_if(! $khachHang || $lichHen->khach_hang_id !== $khachHang->id, 403);
    }

    private function makePaymentCode(): string
    {
        do {
            $code = 'TT' . now()->format('ymdHis') . Str::upper(Str::random(4));
        } while (ThanhToan::where('ma_thanh_toan', $code)->exists());

        return $code;
    }
}
