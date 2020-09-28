<?php

namespace App\Enums;

use BenSampo\Enum\Enum;
use Illuminate\Support\Facades\Storage;

/**
 * @method static static HAKASE()
 * @method static static RUSTARIO()
 * @method static static SUZUKA()
 * @method static static TAKAMIYA()
 * @method static static ARMAL()
 * @method static static YUMETSUKI()
 */
final class Character extends Enum
{
    const ARMAL = 'armal';
    const RUSTARIO =   'rustario';
    const TAKAMIYA = 'takamiya';
    const YUMETSUKI = 'yumetsuki';
    const HAKASE =   'hakase';
    const SUZUKA = 'suzuka';

    /**
     * Get character image url from storage.
     *
     *@param string $character
    * @return string
    */
    public static function getJPName($character)
    {
        switch ($character) {
            case self::HAKASE:
                return '葉加瀬冬雪';
            break;
            case self::RUSTARIO:
                return 'フレン・E・ルスタリオ';
            break;
            case self::SUZUKA:
                return '鈴鹿詩子';
            break;
            case self::TAKAMIYA:
                return '鷹宮リオン';
            break;
            case self::ARMAL:
                return 'アルスアルマル';
            break;
            case self::YUMETSUKI:
                return '夢月ロア';
            break;
            default:
                return null;
        }
    }
}
