<?php

declare(strict_types=1);

namespace App\DataTransferObjects;

use Spatie\DataTransferObject\DataTransferObject;

class AuthorDTO extends DataTransferObject
{
    public string  $surName;
    public string  $name;
    public ?string $patronymic;
}
