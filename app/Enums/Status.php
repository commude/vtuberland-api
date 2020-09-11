<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static FAIL()
 * @method static OK()
 * @method static DRAFT()
 * @method static PENDING()
 * @method static WAIT()
 */
final class Status extends Enum
{
    const FAIL = 0;
    const OK = 1;
    const DRAFT = 5;
    const PENDING = 7;
    const WAIT = 8;
}
