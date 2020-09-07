<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static SMALL()
 * @method static static MEDIUM()
 */
final class PhotoSize extends Enum
{
    const SMALL = [
        'key' => 'small',
        'unit' => 120,
    ];

    const MEDIUM = [
        'key' => 'medium',
        'unit' => 600,
    ];

    const LARGE = [
        'key' => 'large',
        'unit' => 900,
    ];
}
