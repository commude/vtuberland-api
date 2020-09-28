<?php

namespace App\Models;

use App\Models\Traits\HasUUID;
use Spatie\MediaLibrary\Models\Media as BaseMedia;

class Media extends BaseMedia
{
    use HasUUID;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
}
