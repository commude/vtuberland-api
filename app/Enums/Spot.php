<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class Spot extends Enum
{
    const FERRIS_WHEEL = 'ferris_wheel';
    const ANIMAL_RESCUE = 'animal_rescue';
    const AERODACTYL_CYCLE = 'aerodactyl_cycle';
    const GO_KART = 'go_kart';
    const CRAZY_HOUSTON = 'crazy_houston';
    const ROOF_COASTER_MOMONGA = 'roof_coaseter_MOMOnGA';
    const HASHIBORO_GO = 'hashiboro_go';

    /**
     * Get spot image url from storage.
     *
     *@param string $character
    * @return string
    */
    public static function getJPName($spot)
    {
        switch ($spot) {
            case self::ANIMAL_RESCUE:
                return 'アニマルレスキュー';
            break;
            case self::GO_KART:
                return 'ゴーカート';
            break;
            case self::HASHIBORO_GO:
                return 'ハシビロGO！';
            break;
            case self::CRAZY_HOUSTON:
                return 'クレイジーヒュー・ストン';
            break;
            case self::AERODACTYL_CYCLE:
                return 'プテラサイクル';
            break;
            case self::ROOF_COASTER_MOMONGA:
                return 'ループコースターMOMOnGA';
            break;
            case self::FERRIS_WHEEL:
                return '大観覧車';
            break;
            default:
                return null;
        }
    }
}
