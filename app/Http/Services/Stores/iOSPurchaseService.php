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
            dd($body);
            if ($body['status'] != 'success') {
                Log::error('Sandbox verification receipt failed.');
                return false;
            }

            // Parse the purchase data to be stored.
            $this->data = $this->parseReceipt($body);

            return true;
        } catch (Exception $exception) {
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
            $response = $http->post(config('services.ios.store.production'), $this->params());

            $body = json_decode($response->getBody()->getContents(), true);
            dd($body);
            // 0 = itunes success || 21007 = Sandbox success
            return ($body['status'] == 0 || $body['status'] == 21007)
                ? $this->sandboxVerify()
                : false;

        } catch (Exception $exception) {
            Log::error('iTunes verification receipt failed.');
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
        $latestReceipt = collect($body['latest_receipt_info'])->sortByDesc('purchase_date')->first();

        dd($latestReceipt);
        // return [
        //     'original_transaction_id' => $latestReceipt['original_transaction_id'],
        //     'transaction_id' => $latestReceipt['transaction_id'],
        //     'receipt' => $body['latest_receipt'],
        //     'amount' => SubscriptionPlan::getAmount($this->receipt['plan']),
        //     'currency' => 'JPY',
        //     'status' => SubscriptionStatus::SUCCESS['name'],
        //     'purchased_at' => $this->convertEpochToCarbon($latestReceipt['purchase_date_ms']),
        //     'expired_at' => $this->convertEpochToCarbon($latestReceipt['expires_date_ms']),
        // ];
    }

    /**
     * Parse miliseconds epoch to Carbon
     *
     * @return \Illuminate\Support\Carbon
     */
    private function convertEpochToCarbon($epoch)
    {
        $seconds = $epoch / 1000;
        $date = date('d-m-Y H:i:s', $seconds);

        return  new Carbon($date);
    }

    /**
     * Parse sucessful receipt
     *
     * @return array
     */
    private function parseErrorReceipt()
    {
        return [
            'status' => Status::FAIL,
        ];
    }
}
