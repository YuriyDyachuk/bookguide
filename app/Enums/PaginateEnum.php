<?php

declare(strict_types=1);

namespace App\Enums;

use Spatie\Enum\Enum;

/**
 * @method static self countPage()
 */
class PaginateEnum extends Enum
{
    public static function values(): array
    {
        return [
            'countPage' => 15
        ];
    }
}
