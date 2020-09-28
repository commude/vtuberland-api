<?php

namespace App\Http\Services;

use Webpatser\Uuid\Uuid;
use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\PathGenerator\PathGenerator;

class CustomPathGenerator implements PathGenerator
{
    public function getPath(Media $media) : string
    {
        return $media->id . '/';
    }

    public function getPathForConversions(Media $media) : string
    {
        return $this->getPath($media);
    }

    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->getPath($media);
    }
}
