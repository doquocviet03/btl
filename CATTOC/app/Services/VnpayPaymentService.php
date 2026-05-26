<?php

namespace App\Services;

use Illuminate\Support\Arr;

class VnpayPaymentService
{
    public function isConfigured(): bool
    {
        return (bool) config('vnpay.enabled')
            && filled(config('vnpay.tmn_code'))
            && filled(config('vnpay.hash_secret'))
            && filled(config('vnpay.url'));
    }

    public function createPaymentUrl(array $payload): array
    {
        $params = [
            'vnp_Version' => config('vnpay.version', '2.1.0'),
            'vnp_Command' => config('vnpay.command', 'pay'),
            'vnp_TmnCode' => config('vnpay.tmn_code'),
            'vnp_Amount' => (int) Arr::get($payload, 'amount') * 100,
            'vnp_CurrCode' => config('vnpay.curr_code', 'VND'),
            'vnp_TxnRef' => (string) Arr::get($payload, 'txn_ref'),
            'vnp_OrderInfo' => (string) Arr::get($payload, 'order_info', 'Thanh toan Barber House'),
            'vnp_OrderType' => config('vnpay.order_type', 'billpayment'),
            'vnp_Locale' => config('vnpay.locale', 'vn'),
            'vnp_ReturnUrl' => (string) Arr::get($payload, 'return_url'),
            'vnp_IpAddr' => (string) Arr::get($payload, 'ip_address', request()->ip() ?: '127.0.0.1'),
            'vnp_CreateDate' => now()->format('YmdHis'),
        ];

        if (filled(Arr::get($payload, 'bank_code'))) {
            $params['vnp_BankCode'] = Arr::get($payload, 'bank_code');
        }

        ksort($params);

        $hashData = $this->buildHashData($params);
        $query = http_build_query($params, '', '&', PHP_QUERY_RFC3986);
        $secureHash = hash_hmac('sha512', $hashData, (string) config('vnpay.hash_secret'));

        return [
            'params' => $params,
            'hash_data' => $hashData,
            'secure_hash' => $secureHash,
            'payment_url' => rtrim((string) config('vnpay.url'), '?') . '?' . $query . '&vnp_SecureHash=' . $secureHash,
        ];
    }

    public function verifyReturnSignature(array $payload): bool
    {
        if (empty($payload['vnp_SecureHash'])) {
            return false;
        }

        $secureHash = (string) $payload['vnp_SecureHash'];
        $data = $payload;
        unset($data['vnp_SecureHash'], $data['vnp_SecureHashType']);
        ksort($data);

        $hashData = $this->buildHashData($data);
        $calculated = hash_hmac('sha512', $hashData, (string) config('vnpay.hash_secret'));

        return hash_equals($calculated, $secureHash);
    }

    public function isSuccess(array $payload): bool
    {
        return ($payload['vnp_ResponseCode'] ?? null) === '00'
            && ($payload['vnp_TransactionStatus'] ?? null) === '00';
    }

    private function buildHashData(array $params): string
    {
        $pairs = [];
        foreach ($params as $key => $value) {
            if ($value === null || $value === '') {
                continue;
            }
            $pairs[] = urlencode((string) $key) . '=' . urlencode((string) $value);
        }

        return implode('&', $pairs);
    }
}
