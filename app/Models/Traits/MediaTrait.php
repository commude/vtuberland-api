<?php

namespace App\Models\Traits;

use App\Enums\PhotoSize;
use Illuminate\Http\UploadedFile;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;
use Webpatser\Uuid\Uuid;

trait MediaTrait
{
    use HasMediaTrait;

    /**
     * @param $key
     *
     * @return \Spatie\MediaLibrary\FileAdder\FileAdder
     */
    public function addMediaFromRequestUsingUuid($key)
    {
        return $this->addMediaUsingUuid(request()->file($key));
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion(PhotoSize::SMALL['key'])
            ->width(PhotoSize::SMALL['unit'])
            ->height(PhotoSize::SMALL['unit']);
        $this->addMediaConversion(PhotoSize::MEDIUM['key'])
            ->width(PhotoSize::MEDIUM['unit'])
            ->height(PhotoSize::MEDIUM['unit']);
        $this->addMediaConversion(PhotoSize::LARGE['key'])
            ->width(PhotoSize::LARGE['unit'])
            ->height(PhotoSize::LARGE['unit']);
    }

    /**
     * @param $mediaId media id or Media instance
     *
     * @return bool
     */
    public function isOwnMedia($mediaId)
    {
        if ($mediaId instanceof Media) {
            $mediaId = $mediaId->id;
        }

        return $this->media->find($mediaId) ? true : false;
    }
}
