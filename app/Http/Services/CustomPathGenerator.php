<?php

namespace App\Http\Services;

use Webpatser\Uuid\Uuid;
use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\PathGenerator\PathGenerator;

class CustomPathGenerator implements PathGenerator
{
    public function getPath(Media $media) : string
    {
        return mb_convert_encoding(Uuid::generate(4), 'UTF-8', 'UTF-8') . '/';
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
