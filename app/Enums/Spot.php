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
    const ANIMAL_RESCUE = 'animal_rescue';
    const GO_KART = 'go_kart';
    const HASHIBORO_GO = 'hashiboro_go';
    const CRAZY_HOUSTON = 'crazy_houston';
    const AERODACTYL_CYCLE = 'aerodactyl_cycle';
    const ROOF_COASTER_MOMONGA = 'roof_coaseter_MOMOnGA';
    const FERRIS_WHEEL = 'ferris_wheel';

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

    /**
     * Get spot image url from storage.
     *
     *@param string $character
    * @return string
    */
    public static function getBeaconID($spot)
    {
        switch ($spot) {
            case self::ANIMAL_RESCUE:
                return '11111111-1111-1111-1111-111111111111';
            break;
            case self::GO_KART:
                return '11111111-1111-1111-1111-111111111111-1';
            break;
            case self::HASHIBORO_GO:
                return '22222222-2222-2222-2222-222222222222';
            break;
            case self::CRAZY_HOUSTON:
                return '11111111-1111-1111-1111-111111111111-11';
            break;
            case self::AERODACTYL_CYCLE:
                return '11111111-1111-1111-1111-111111111111-111';
            break;
            case self::ROOF_COASTER_MOMONGA:
                return '22222222-2222-2222-2222-222222222222-2';
            break;
            case self::FERRIS_WHEEL:
                return '22222222-2222-2222-2222-222222222222-22';
            break;
            default:
                return null;
        }
    }
}
