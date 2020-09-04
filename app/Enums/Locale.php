<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static JAPAN()
 * @method static static US()
 * @method static static OptionThree()
 */
final class Locale extends Enum
{
    const JAPAN = 'ja_JP';
    const US = 'en_EN';
    const OptionThree = 2;
}
