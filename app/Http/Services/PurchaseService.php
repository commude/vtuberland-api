<?php

namespace App\Http\Services;

use App\Enums\Store;
use App\Exceptions\StoreNotSupportedException;
use App\Http\Services\Stores\iOSPurchaseService;
use App\Http\Services\Stores\AndroidPurchaseService;

class PurchaseService
{
    /**
     * Process the transactions on the stores.
     *
     * @param Array $transaction
     */
    public function verify($transaction)
    {
        if (!in_array($transaction['app'], Store::getValues())) {
            throw new StoreNotSupportedException();
        }

        switch ($transaction['app']) {
            case Store::APPLE:
                $service = new iOSPurchaseService($transaction);
                $transaction = $service->transact();
            break;
            case Store::GOOGLE:
                $service = new AndroidPurchaseService($transaction);
                $transaction = $service->transact();
            break;
        }

        return $transaction;
    }
}
