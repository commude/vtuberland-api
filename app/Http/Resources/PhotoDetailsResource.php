<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Enums\PhotoSize;
use Spatie\MediaLibrary\Exceptions\InvalidConversion;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class PhotoDetailsResource extends JsonResource
{
    use HasMediaTrait;

    /**
     * Declare unit size of the photo.
     *
     * @var
     */
    protected $unit;

    /**
     * Declare name size of the photo.
     *
     * @var
     */
    protected $name;

    /**
     * Create a new resource instance.
     *
     * @param mixed $resource
     * @param $details
     */
    public function __construct($resource, $details = null)
    {
        parent::__construct($resource);
        $this->resource = $resource;
        if ($details) {
            $this->unit = $details['unit'];
            $this->name = $details['key'];
        }
    }

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        try {
            $url = $this->getUrl($this->name ?? '');
        } catch (InvalidConversion $e) {
            return [
                'url' => null,
                'height' => null,
                'width' => null,
            ];
        }

        $dimensions = $this->getImageDimensions($this->name);

        return [
            'url' => $url,
            'height' => $dimensions['height'],
            'width' => $dimensions['width'],
        ];
    }

    /**
     * Get the Image Dimensions.
     *
     * @param string $size_name
     *
     * @return array
     */
    public function getImageDimensions($size_name)
    {
        switch ($size_name) {
            case PhotoSize::SMALL['key']:
                return $this->computeNewDimensions($this->unit);
            break;
            case PhotoSize::MEDIUM['key']:
                return $this->computeNewDimensions($this->unit);
            break;
            default:
                return [
                    'height' => $this->getCustomProperty('height'),
                    'width' => $this->getCustomProperty('width'),
                ];
            break;
        }
    }

    /**
     * Calculate Image Width and Height.
     *
     * @param int $size
     *
     * @return array
     */
    public function computeNewDimensions($size)
    {
        $height = $this->getCustomProperty('height');
        $width = $this->getCustomProperty('width');

        if ($height && $width) {
            // Check portrait orientation
            if ($height > $width) {
                $width = floor($size * $width / $height);
                $height = $size;
            } else {
                $height = floor($size * $height / $width);
                $width = $size;
            }
        }

        return compact('height', 'width');
    }
}
