<?php

declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Model;

class MediaRepository
{
    public function saveMedia(Model $model, UploadedFile $media)
    {
        $model->addMedia($media)->toMediaCollection('media', 'media');
    }

    public function remove(Model $model): void
    {
        $model->clearMediaCollectionExcept('media', $model->getFirstMedia());
    }
}
