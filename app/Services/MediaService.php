<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Http\UploadedFile;
use App\Repositories\MediaRepository;
use Illuminate\Database\Eloquent\Model;

class MediaService
{
    protected MediaRepository $mediaRepository;

    public function __construct(MediaRepository $mediaRepository)
    {
        $this->mediaRepository = $mediaRepository;
    }

    public function storeMedia(Model $model, UploadedFile $file): void
    {
        $this->mediaRepository->saveMedia($model,$file);
    }

    public function updateMedia(Model $model, ?UploadedFile $file): void
    {
        if ($file) {
            $this->deleteMedia($model);
            $this->storeMedia($model, $file);
        }
    }

    public function deleteMedia(Model $model): void
    {
        $this->mediaRepository->remove($model);
    }
}
