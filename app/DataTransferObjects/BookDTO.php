<?php

declare(strict_types=1);

namespace App\DataTransferObjects;

use Carbon\Carbon;
use Spatie\DataTransferObject\DataTransferObject;

class BookDTO extends DataTransferObject
{
    public string  $name;
    public string  $description;
    public ?Carbon $published;
}
