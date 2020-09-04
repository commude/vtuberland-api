<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static IOS()
 * @method static static ANDROID()
 */
final class OperatingSystem extends Enum
{
    const IOS = 'iOS';
    const ANDROID = 'android';
}
