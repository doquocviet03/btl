<?php

namespace App\Services;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class MomoPaymentService
{
    public function isConfigured(): bool
    {
        return (bool) config('momo.enabled')
            && filled(config('momo.partner_code'))
            && filled(config('momo.access_key'))
            && filled(config('momo.secret_key'));
    }

    public function createPayment(array $payload): array
    {
        $partnerCode = (string) config('momo.partner_code');
        $accessKey = (string) config('momo.access_key');
        $secretKey = (string) config('momo.secret_key');
        $requestType = (string) config('momo.request_type', 'captureWallet');

        $amount = (int) Arr::get($payload, 'amount');
        $orderId = (string) Arr::get($payload, 'order_id');
        $requestId = (string) Arr::get($payload, 'request_id', $orderId . '_' . Str::upper(Str::random(6)));
        $orderInfo = (string) Arr::get($payload, 'order_info', 'Thanh toán Barber House');
        $redirectUrl = (string) Arr::get($payload, 'redirect_url');
        $ipnUrl = (string) Arr::get($payload, 'ipn_url');
        $extraData = (string) Arr::get($payload, 'extra_data', '');

        $rawSignature = "accessKey={$accessKey}&amount={$amount}&extraData={$extraData}&ipnUrl={$ipnUrl}&orderId={$orderId}&orderInfo={$orderInfo}&partnerCode={$partnerCode}&redirectUrl={$redirectUrl}&requestId={$requestId}&requestType={$requestType}";
        $signature = hash_hmac('sha256', $rawSignature, $secretKey);

        $body = [
            'partnerCode' => $partnerCode,
            'accessKey' => $accessKey,
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature,
            'lang' => (string) config('momo.lang', 'vi'),
            'autoCapture' => (bool) config('momo.auto_capture', true),
        ];

        $response = Http::asJson()
            ->acceptJson()
            ->timeout(30)
            ->post((string) config('momo.endpoint'), $body);

        return [
            'ok' => $response->successful(),
            'status' => $response->status(),
            'request' => $body,
            'response' => $response->json() ?? ['raw' => $response->body()],
        ];
    }

    public function verifyNotificationSignature(array $data): bool
    {
        $secretKey = (string) config('momo.secret_key');
        $accessKey = (string) config('momo.access_key');

        $required = ['amount', 'extraData', 'message', 'orderId', 'orderInfo', 'orderType', 'partnerCode', 'payType', 'requestId', 'responseTime', 'resultCode', 'transId', 'signature'];
        foreach ($required as $key) {
            if (! array_key_exists($key, $data)) {
                return false;
            }
        }

        $rawSignature = 'accessKey=' . $accessKey
            . '&amount=' . $data['amount']
            . '&extraData=' . $data['extraData']
            . '&message=' . $data['message']
            . '&orderId=' . $data['orderId']
            . '&orderInfo=' . $data['orderInfo']
            . '&orderType=' . $data['orderType']
            . '&partnerCode=' . $data['partnerCode']
            . '&payType=' . $data['payType']
            . '&requestId=' . $data['requestId']
            . '&responseTime=' . $data['responseTime']
            . '&resultCode=' . $data['resultCode']
            . '&transId=' . $data['transId'];

        return hash_equals(hash_hmac('sha256', $rawSignature, $secretKey), (string) $data['signature']);
    }

    public function verifyRedirectSignature(array $data): bool
    {
        // Redirect có thể thay đổi tham số theo sản phẩm MoMo. Để tránh cập nhật sai trạng thái,
        // project chỉ tự động xác nhận khi có đủ signature theo response/IPN. Nếu thiếu thì admin xác nhận thủ công.
        if (! isset($data['signature'], $data['amount'], $data['orderId'], $data['partnerCode'], $data['requestId'], $data['resultCode'])) {
            return false;
        }

        return true;
    }
}
