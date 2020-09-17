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
    protected $receipt;

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
     * Verify the Receipt is valid
     *
     * @param \App\Models\Transaction $transaction
     * @param \App\Models\User $user
     */
    public function transact()
    {
        $isVerified = $this->verify();

        if (!$isVerified) {
            return $this->parseErrorReceipt();
        }

        return $this->data;
    }

    /**
     * Verify the receipt is valid
     *
     * @return boolean
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
            $product_purchased = $service->purchases_products->get(config('services.google.package_name'), $this->receipt['product_id'], $this->receipt['purchase_token']);

            dd($product_purchased);
            if (is_null($product_purchased) || isset($product_purchased['error']['code']) || !isset($product_purchased['expiryTimeMillis'])) {
                    $code = $product_purchased['error']['code'] ?? 0;
                    $message = is_null($product_purchased) ? 'No Respoonse from Google Client.' : 'Invalid receipt.';

                    Log::error("Invalid Receipt -- return code: {$code}; message: {$message}");
                    return false;
            }

            $this->data = $this->parseReceipt($product_purchased);

            return true;
        } catch (Exception $e) {
            $exception = json_decode($e->getMessage(), true);
            throw new InvalidReceiptException($exception['error']['code'] . ' ' . $exception['error']['message']);
        }
    }

    /**
     * Parse sucessful receipt
     *
     * @return array
     */
    private function parseReceipt($body)
    {
        return [
            'original_transaction_id' => $this->receipt['purchase_token'],
            'transaction_id' => $body['orderId'],
            'purchase_token' => $this->receipt['purchase_token'],
            'amount' => $body['priceAmountMicros'] * 0.000001,
            'currency' => $body['priceCurrencyCode'],
            'status' => Status::OK,
            'purchased_at' => new Carbon(date("d-m-Y H:i:s", $body['startTimeMillis'] / 1000)),
            'expired_at' => new Carbon(date("d-m-Y H:i:s", $body['expiryTimeMillis'] / 1000)),
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
            'status' => Status::FAIL
        ];
    }
}
