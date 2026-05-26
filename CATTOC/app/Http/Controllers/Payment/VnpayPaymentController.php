<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\DonHang;
use App\Models\LichHen;
use App\Models\ThanhToan;
use App\Models\ThongBao;
use App\Services\VnpayPaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class VnpayPaymentController extends Controller
{
    public function __construct(private readonly VnpayPaymentService $vnpayPaymentService)
    {
    }

    public function createForAppointment(Request $request, LichHen $lichHen)
    {
        $this->ensureAppointmentOwner($lichHen);
        $lichHen->load(['khachHang', 'thanhToan']);

        $thanhToan = $lichHen->thanhToan ?: ThanhToan::create([
            'lich_hen_id' => $lichHen->id,
            'ma_thanh_toan' => $this->makePaymentCode(),
            'so_tien' => $lichHen->tong_tien,
            'phuong_thuc' => 'vnpay',
            'trang_thai' => 'chua_thanh_toan',
        ]);

        if ($thanhToan->trang_thai === 'da_thanh_toan') {
            return back()->with('success', 'Lịch hẹn này đã được thanh toán.');
        }

        if (! $this->vnpayPaymentService->isConfigured()) {
            $thanhToan->update([
                'phuong_thuc' => 'vnpay',
                'ghi_chu' => trim(($thanhToan->ghi_chu ? $thanhToan->ghi_chu . "\n" : '') . 'Khách chọn VNPAY Sandbox/Demo nhưng chưa cấu hình VNPAY_TMN_CODE/VNPAY_HASH_SECRET.'),
            ]);

            return back()->with('error', 'Chưa cấu hình VNPAY sandbox. Hãy điền VNPAY_TMN_CODE và VNPAY_HASH_SECRET trong .env, sau đó chạy php artisan optimize:clear.');
        }

        $txnRef = 'TT' . $thanhToan->id . '_' . now()->format('ymdHis') . '_' . Str::upper(Str::random(4));
        $result = $this->vnpayPaymentService->createPaymentUrl([
            'amount' => (int) round($thanhToan->so_tien),
            'txn_ref' => $txnRef,
            'order_info' => 'Thanh toan lich hen ' . $lichHen->ma_lich_hen,
            'return_url' => route('vnpay.appointment.return', $lichHen),
            'ip_address' => $request->ip(),
            'bank_code' => $request->bank_code,
        ]);

        $thanhToan->update([
            'phuong_thuc' => 'vnpay',
            'vnpay_txn_ref' => $txnRef,
            'vnpay_payment_url' => $result['payment_url'],
            'vnpay_payload' => json_encode($result, JSON_UNESCAPED_UNICODE),
        ]);

        return redirect()->away($result['payment_url']);
    }

    public function appointmentReturn(Request $request, LichHen $lichHen)
    {
        $lichHen->load('thanhToan');
        $thanhToan = $lichHen->thanhToan;

        if ($thanhToan) {
            $this->syncVnpayResult($request->all(), $thanhToan, null, true);
        }

        return redirect()->route('public.thanh-toan.index', $lichHen)
            ->with('success', 'Đã quay lại từ VNPAY. Nếu giao dịch thành công, trạng thái thanh toán đã được cập nhật.');
    }

    public function createForOrder(Request $request, DonHang $donHang)
    {
        if ($donHang->trang_thai_thanh_toan === 'da_thanh_toan') {
            return back()->with('success', 'Đơn hàng này đã được thanh toán.');
        }

        if (! $this->vnpayPaymentService->isConfigured()) {
            $donHang->update([
                'phuong_thuc_thanh_toan' => 'vnpay',
                'trang_thai_thanh_toan' => 'dang_cho_xac_nhan',
                'ghi_chu' => trim(($donHang->ghi_chu ? $donHang->ghi_chu . "\n" : '') . 'Khách chọn VNPAY Sandbox/Demo nhưng chưa cấu hình VNPAY_TMN_CODE/VNPAY_HASH_SECRET.'),
            ]);

            return back()->with('error', 'Chưa cấu hình VNPAY sandbox. Hãy điền VNPAY_TMN_CODE và VNPAY_HASH_SECRET trong .env.');
        }

        $txnRef = 'DH' . $donHang->id . '_' . now()->format('ymdHis') . '_' . Str::upper(Str::random(4));
        $result = $this->vnpayPaymentService->createPaymentUrl([
            'amount' => (int) round($donHang->tong_tien),
            'txn_ref' => $txnRef,
            'order_info' => 'Thanh toan don hang ' . $donHang->ma_don_hang,
            'return_url' => route('vnpay.order.return', $donHang),
            'ip_address' => $request->ip(),
            'bank_code' => $request->bank_code,
        ]);

        $donHang->update([
            'phuong_thuc_thanh_toan' => 'vnpay',
            'trang_thai_thanh_toan' => 'dang_cho_xac_nhan',
            'vnpay_txn_ref' => $txnRef,
            'vnpay_payment_url' => $result['payment_url'],
            'vnpay_payload' => json_encode($result, JSON_UNESCAPED_UNICODE),
        ]);

        return redirect()->away($result['payment_url']);
    }

    public function orderReturn(Request $request, DonHang $donHang)
    {
        $this->syncVnpayResult($request->all(), null, $donHang, true);

        return redirect()->route('public.gio-hang.thanh-cong', $donHang)
            ->with('success', 'Đã quay lại từ VNPAY. Nếu giao dịch thành công, trạng thái đơn hàng đã được cập nhật.');
    }

    public function ipn(Request $request)
    {
        $payload = $request->all();
        $txnRef = $payload['vnp_TxnRef'] ?? null;

        if (! $this->vnpayPaymentService->verifyReturnSignature($payload)) {
            Log::warning('VNPAY IPN signature invalid', $payload);
            return response()->json(['RspCode' => '97', 'Message' => 'Invalid signature']);
        }

        $found = false;
        DB::transaction(function () use ($payload, $txnRef, &$found) {
            if ($thanhToan = ThanhToan::where('vnpay_txn_ref', $txnRef)->lockForUpdate()->first()) {
                $found = true;
                $this->syncVnpayResult($payload, $thanhToan, null, false);
                return;
            }

            if ($donHang = DonHang::where('vnpay_txn_ref', $txnRef)->lockForUpdate()->first()) {
                $found = true;
                $this->syncVnpayResult($payload, null, $donHang, false);
            }
        });

        if (! $found) {
            return response()->json(['RspCode' => '01', 'Message' => 'Order not found']);
        }

        return response()->json(['RspCode' => '00', 'Message' => 'Confirm Success']);
    }

    private function syncVnpayResult(array $payload, ?ThanhToan $thanhToan = null, ?DonHang $donHang = null, bool $fromReturn = false): void
    {
        if (! $this->vnpayPaymentService->verifyReturnSignature($payload)) {
            return;
        }

        $success = $this->vnpayPaymentService->isSuccess($payload);
        $amount = isset($payload['vnp_Amount']) ? ((int) $payload['vnp_Amount'] / 100) : 0;
        $updateBase = [
            'vnpay_transaction_no' => $payload['vnp_TransactionNo'] ?? null,
            'vnpay_response_code' => $payload['vnp_ResponseCode'] ?? null,
            'vnpay_transaction_status' => $payload['vnp_TransactionStatus'] ?? null,
            'vnpay_bank_code' => $payload['vnp_BankCode'] ?? null,
            'vnpay_pay_date' => $payload['vnp_PayDate'] ?? null,
            'vnpay_payload' => json_encode($payload, JSON_UNESCAPED_UNICODE),
        ];

        if ($thanhToan) {
            $update = $updateBase;
            if ($success && (int) round($thanhToan->so_tien) === (int) round($amount)) {
                $update['trang_thai'] = 'da_thanh_toan';
                $update['ngay_thanh_toan'] = now();
            } elseif (($payload['vnp_ResponseCode'] ?? null) && ! $success) {
                $update['trang_thai'] = 'that_bai';
            }

            $thanhToan->update($update);

            if ($success) {
                $thanhToan->lichHen?->update(['trang_thai' => 'hoan_thanh']);
                ThongBao::create([
                    'tieu_de' => 'VNPAY xác nhận thanh toán',
                    'noi_dung' => 'Giao dịch VNPAY cho ' . ($thanhToan->lichHen->ma_lich_hen ?? $thanhToan->ma_thanh_toan) . ' đã thành công.',
                    'loai' => 'thanh_toan',
                    'lien_ket' => route('admin.thanh-toan.edit', $thanhToan->id, false),
                    'da_doc' => 0,
                ]);
            }
        }

        if ($donHang) {
            $update = $updateBase;
            if ($success && (int) round($donHang->tong_tien) === (int) round($amount)) {
                $update['trang_thai_thanh_toan'] = 'da_thanh_toan';
            } elseif (($payload['vnp_ResponseCode'] ?? null) && ! $success) {
                $update['trang_thai_thanh_toan'] = 'that_bai';
            }

            $donHang->update($update);

            if ($success) {
                ThongBao::create([
                    'tieu_de' => 'VNPAY xác nhận đơn hàng',
                    'noi_dung' => 'Đơn hàng ' . $donHang->ma_don_hang . ' đã thanh toán VNPAY thành công.',
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
