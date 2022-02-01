<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\MediaTypeEnum;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Book extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'description',
        'published'
    ];

    protected $casts = [
        'published' => 'datetime'
    ];

    #================================== [CUSTOM METHODS] ==================================#

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('media')
            ->registerMediaConversions(function (Media $media) {
                $this
                    ->addMediaConversion('small')
                    ->width(MediaTypeEnum::width()->value)
                    ->height(MediaTypeEnum::height()->value)
                    ->sharpen(MediaTypeEnum::sharpen()->value)
                    ->nonQueued();
            });
    }
}
