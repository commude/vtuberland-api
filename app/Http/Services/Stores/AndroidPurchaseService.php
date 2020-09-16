<?php

namespace App\Http\Services\Stores;

use Exception;
use Google_Client;
use App\Enums\Status;
use Illuminate\Support\Carbon;
use Google_Service_AndroidPublisher;
use App\Exceptions\InvalidReceiptException;
use Illuminate\Support\Facades\Log;

class AndroidPurchaseService
{
    protected $transaction;

    /**
     * Create a new event instance.
     *
     * @param \App\Models\Transaction $transaction
     * @param string $secret
     *
     * @return void
     */
    public function __construct($transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Verify the Receipt is valid
     *
     * @param \App\Models\Transaction $transaction
     * @param \App\Models\User $user
     */
    public function transact()
    {
        $isVerified = $this->verify();

        if (!$isVerified) {
            throw new InvalidReceiptException;
        }

        return $this->data;
    }

    /**
     * Verify the receipt is valid
     *
     * @param \App\Models\Transaction $transaction
     * @param \App\Models\User $user
     */
    public function verify()
    {
        try {
            $client = new Google_Client();
            $client->setApplicationName(config('app.name'));
            $client->setAuthConfig(config('auth.google.service-account'));
            $client->setScopes(['https://www.googleapis.com/auth/androidpublisher']);

            // Instantiate the Android Publisher service class using client.
            $service = new Google_Service_AndroidPublisher($client);

            // Check the purchase and consumption status of an inapp item.
            $product_purchased = $service->purchases_products->get(config('services.google.package_name'), $this->transaction['product_id'], $this->transaction['purchase_token']);

            if (is_null($product_purchased)
                || isset($product_purchased['error']['code'])
                || !isset($product_purchased['expiryTimeMillis'])) {
                    $code = $product_purchased['error']['code'];

                    $this->data['status'] = Status::FAIL;
                    Log::error("Purchase Failed -- return code: {$code}");
                    return false;
            }

            $this->data = [
                'original_transaction_id' => $this->transaction['purchase_token'],
                'transaction_id' => $product_purchased['orderId'],
                'purchase_token' => $this->transaction['purchase_token'],
                'amount' => $product_purchased['priceAmountMicros'] * 0.000001,
                'currency' => $product_purchased['priceCurrencyCode'],
                'status' => Status::OK,
                'purchased_at' => new Carbon(date("d-m-Y H:i:s", $product_purchased['startTimeMillis'] / 1000)),
                'expired_at' => new Carbon(date("d-m-Y H:i:s", $product_purchased['expiryTimeMillis'] / 1000)),
            ];

            return true;
        } catch (Exception $e) {
            $exception = json_decode($e->getMessage(), true);
            throw new InvalidReceiptException($exception['error']['code'] . ' ' . $exception['error']['message']);
        }
    }
}
