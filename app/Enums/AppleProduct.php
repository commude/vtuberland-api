<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class AppleProduct extends Enum
{
    const FREE= '0000';
    const TIGER = '00002';

    /**
     * Set Filter for amount
     *
     *@param string $filter
    * @return string
    */
    public static function getAmount($plan)
    {
        switch ($plan) {
            case self::FREE:
                return 0;
            break;
            case self::TIGER:
                return 440;
            break;
        }
    }
}
