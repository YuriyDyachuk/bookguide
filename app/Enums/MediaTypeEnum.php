<?php

declare(strict_types=1);

namespace App\Enums;

use Spatie\Enum\Enum;

/**
 * @method static self width()
 * @method static self height()
 * @method static self sharpen()
 */
class MediaTypeEnum extends Enum
{
    public static function values(): array
    {
        return [
            'width'     => 348,
            'height'    => 273,
            'sharpen'   => 10
        ];
    }
}
