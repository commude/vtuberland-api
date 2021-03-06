<?php

namespace App\Http\Services\Stores;

use Exception;
use App\Enums\Status;
use GuzzleHttp\Client;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use App\Exceptions\InvalidReceiptException;

class iOSPurchaseService
{
    protected $receipt;
    protected $exception_message;
    protected $data;

    /**
     * Create a new event instance.
     *
     * @param array $receipt
     * @param string $secret
     *
     * @return void
     */
    public function __construct($receipt)
    {
        $this->receipt = $receipt;
    }

    /**
     * Construct parameters to be sent in the endpoint
     */
    private function params()
    {
        return [
            'json' => [
                'receipt-data' => $this->receipt,
                'password' => config('auth.apple.secret')
            ]
        ];
    }

    /**
     * Construct headers to be sent in the endpoint
     */
    private function headers()
    {
        return [
            'headers' => [
                'Content-Type' => 'application/json',
            ]
        ];
    }

    /**
     * Verify the Receipt is valid
     */
    public function transact()
    {
        $isVerified = false;

        $isVerified = $this->verify();

        if (!$isVerified) {
            return $this->parseErrorReceipt();
        }

        return $this->data;
    }

    /**
     * Verify the Receipt is valid in test environment
     *
     * @return boolean
     */
    public function sandboxVerify()
    {
        $http = new Client($this->headers());

        try {
            $response = $http->post(config('services.apple.store.test'), $this->params());

            $body = json_decode($response->getBody()->getContents(), true);

            Log::info('Test Request Data', ['params' => $this->params()]);

            // 0 - success
            if ($body['status'] != 0) {
                $receipt = json_encode($this->receipt);
                Log::error("Sandbox receipt verification failed.\nReceipt: {$receipt}");

                $this->exception_message = "Sandbox receipt verification failed. Receipt data: {$receipt}";
                return false;
            }

            // Parse the purchase data to be stored.
            $this->data = $this->parseReceipt($body);

            return true;
        } catch (Exception $e) {
            $receipt = json_encode($this->receipt);
            $message = $e->getMessage();

            $this->exception_message = $message;
            Log::error("Sandbox verification receipt failed.\nException: {$message}\nReceipt: {$receipt}");

            return false;
        }
    }

    /**
     * Verify the receipt is valid in production.
     * Purchase flow in Apple requires verifying the receipt first in iTunes endpoint then sandbox endpoint.
     *
     * @return boolean
     */
    public function verify()
    {
        $http = new Client($this->headers());

        try {
            $response = $http->post(config('services.apple.store.production'), $this->params());

            $body = json_decode($response->getBody()->getContents(), true);

            Log::info('Production Request Data', ['params' => $this->params()]);

            // 0 = itunes success
            if($body['status'] == 0){
                $this->data = $this->parseReceipt($body);
                return true;
            }

            // 21007 = Sandbox success
            return ($body['status'] == 21007)
                ? $this->sandboxVerify()
                : false;

        } catch (Exception $e) {
            $receipt = $this->receipt;
            $message = $e->getMessage();

            $this->exception_message = $message;
            Log::error("iTunes verification receipt failed.\nException: {$message}\nReceipt: {$receipt}");

            return false;
        }
    }

    /**
     * Parse sucessful receipt
     *
     * @return array
     */
    private function parseReceipt($body)
    {
        $receiptItem = collect($body['receipt']['in_app'])->sortByDesc('purchase_date')->first();

        return [
            'product_id' => $receiptItem['product_id'],
            'bundle_id' => $body['receipt']['bundle_id'],
            'download_id' => $body['receipt']['download_id'],
            'receipt' => json_encode($body['receipt']),
            // 'amount' => AppleProduct::getAmount($body['receipt']['app_item_id']),
            'currency' => 'JPY',
            'status' => Status::OK,
            'purchased_at' => new Carbon(date('d-m-Y H:i:s', (int) $receiptItem['purchase_date_ms'] / 1000)),
        ];
    }

    /**
     * Parse sucessful receipt
     *
     * @return array
     */
    private function parseErrorReceipt()
    {
        return [
            'receipt' => $this->receipt,
            'status' => Status::FAIL,
            'exception_message' => $this->exception_message,
        ];
    }
}
