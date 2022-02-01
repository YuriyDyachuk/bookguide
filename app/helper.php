<?php

use Carbon\Carbon;

/* Change the date type for a book */
if (!function_exists('changeTypeDate')) {
    function changeTypeDate(string $publishedAt): Carbon
    {
        return Carbon::make($publishedAt);
    }
}

if (!function_exists('explodeString')) {
    function explodeString(string $ids): array
    {
        return explode(',', $ids);
    }
}
