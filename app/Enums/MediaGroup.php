<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class MediaGroup extends Enum
{
    const ATTRACTIONS =  [
        'main' => 'AttractionMainPhotos',
        'photos' => 'AttractionPhotos'
    ];

    const CHARACTERS =   [
        'main' => 'CharacterMainPhotos',
        'photos' => 'CharacterPhotos'
    ];
}
