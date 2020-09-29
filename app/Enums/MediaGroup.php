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
    const SPOTS =  [
        'main' => 'SpotMainPhotos',
        'photos' => 'SpotPhotos'
    ];

    const USERS =  [
        'avatar' => 'userAvatars'
    ];

    const CHARACTERS =   [
        'main' => 'CharacterMainPhotos',
        'photos' => 'CharacterPhotos'
    ];
}
