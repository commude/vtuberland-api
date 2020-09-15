<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Lang;

class InvalidReceiptException extends Exception
{
    protected $message;

    protected $code;

    /**
     * Create a new exception instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->message = Lang::get('purchase.receipt.invalid');
        $this->code = 0;
    }
}
