<?php

namespace App\Models\Traits;

use Webpatser\Uuid\Uuid;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

trait HasUUID
{
    /**
     *  Setup model event hooks
     */
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->getConnection()->getSchemaBuilder()->hasColumn($model->getTable(), 'uuid')
                ? $model->uuid = self::generateUuid()
                : $model->id = self::generateUuid();
        });
    }

    /**
     * Call to generate UUID.
     *
     * @return string
     */
    public static function generateUuid()
    {
        return mb_convert_encoding(Uuid::generate(4), 'UTF-8', 'UTF-8');
    }

    /**
     * @param \Illuminate\Http\UploadedFile $uploadedFile
     * @return \Spatie\MediaLibrary\FileAdder\FileAdder
     *
     * @throws \Exception
     */
    public function addMediaUsingUuid(UploadedFile $uploadedFile)
    {
        $extension = $uploadedFile->getClientOriginalExtension();

        return $this->addMedia($uploadedFile)
            ->usingFileName($this->generateUuid().'.'.$extension);
    }
}
