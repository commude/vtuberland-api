<?php

namespace App\Http\Services\Stores;

use App\Enums\GoogleProduct;
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
    protected $exception_message;

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

            if (is_null($product_purchased) || isset($product_purchased['error']['code']) || !isset($product_purchased['expiryTimeMillis'])) {
                    $code = $product_purchased['error']['code'] ?? 0;
                    $message = is_null($product_purchased) ? 'No Respoonse from Google Client.' : 'Invalid receipt.';
                    $receipt = json_encode($this->receipt);

                    $this->exception_message = $message;
                    Log::error("Invalid Receipt.\nReturn Code: {$code}\nMessage: {$message}\nReceipt: {$receipt}");

                    return false;
            }

            $this->data = $this->parseReceipt($product_purchased);

            return true;
        } catch (Exception $e) {
            $exception = json_decode($e->getMessage(), true);
            $receipt = json_encode($this->receipt);
            $message = $exception['error']['message'];

            $this->exception_message = $message;
            Log::error("Google Play receipt verification failed.\nException: {$message}\nReceipt: {$receipt}");

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
        return [
            'product_id' => $body['productId'],
            'bundle_id' =>$body['orderId'],
            'purchase_token' => $body['purchaseToken'],
            'receipt' => json_encode($this->receipt),
            'amount' => GoogleProduct::getAmount($body['productId']), // $body['priceAmountMicros'] * 0.000001,
            'currency' => 'JPY',
            'status' => Status::OK,
            'purchased_at' => new Carbon(date("d-m-Y H:i:s", $body['purchaseTimeMillis'] / 1000)),
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
            'status' => Status::FAIL,
            'exception_message' => $this->exception_message
        ];
    }
}
