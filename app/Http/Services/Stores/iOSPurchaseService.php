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
    protected $transaction;
    protected $data;

    /**
     * Create a new event instance.
     *
     * @param array $transaction
     * @param string $secret
     *
     * @return void
     */
    public function __construct($transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Construct parameters to be sent in the endpoint
     */
    private function params()
    {
        return [
            'json' => [
                'receipt-data' => $this->transaction['receipt'],
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
            throw new InvalidReceiptException;
        }

        return $this->data;
    }

    /**
     * Verify the Receipt is valid in test environment
     */
    public function sandboxVerify()
    {
        $http = new Client($this->headers());

        try {
            $response = $http->post(config('services.apple.store.test'), $this->params());

            $body = json_decode($response->getBody()->getContents(), true);

            $this->data = $this->parseReceipt($body);

            if ($body['status'] != 'success') {
                Log::error('Sandbox verification receipt failed.');
                $this->transaction['status'] = Status::FAIL;
                return false;
            }

            return true;
        } catch (Exception $exception) {
            return false;
        }
    }

    /**
     * Verify the receipt is valid in production.
     * Purchase flow in Apple requires verifying the receipt first in iTunes endpoint then sandbox endpoint.
     */
    public function verify()
    {
        $http = new Client($this->headers());

        try {
            $response = $http->post(config('services.ios.store.production'), $this->params());

            $body = json_decode($response->getBody()->getContents(), true);

            /*
                0 = itunes success
                21007 = Sandbox success
             */
            switch ($body['status']) {
                case 0:
                case 21007:
                    return $this->sandboxVerify();
                break;
            }

            return false;
        } catch (Exception $exception) {
            Log::error('iTunes verification receipt failed.');
            return false;
        }
    }

    /**
     * Parse sucessful receipt
     */
    private function parseReceipt($body)
    {
        $latestReceipt = collect($body['latest_receipt_info'])->sortByDesc('purchase_date')->first();

        dd($latestReceipt);
        // return [
        //     'plan' => $this->transaction['plan'],
        //     'type' => $this->transaction['type'],
        //     'original_transaction_id' => $latestReceipt['original_transaction_id'],
        //     'transaction_id' => $latestReceipt['transaction_id'],
        //     'receipt' => $body['latest_receipt'],
        //     'amount' => SubscriptionPlan::getAmount($this->transaction['plan']),
        //     'currency' => 'JPY',
        //     'status' => SubscriptionStatus::SUCCESS['name'],
        //     'purchased_at' => $this->convertEpochToCarbon($latestReceipt['purchase_date_ms']),
        //     'expired_at' => $this->convertEpochToCarbon($latestReceipt['expires_date_ms']),
        // ];
    }

    /**
     * Parse miliseconds epoch to Carbon
     */
    private function convertEpochToCarbon($epoch)
    {
        $seconds = $epoch / 1000;
        $date = date('d-m-Y H:i:s', $seconds);
        return  new Carbon($date);
    }
}
