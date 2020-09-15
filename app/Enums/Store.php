<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static APPLE()
 * @method static static GOOGLE()
 */
final class Store extends Enum
{
    const APPLE = 'apple';
    const GOOGLE = 'google';
}
