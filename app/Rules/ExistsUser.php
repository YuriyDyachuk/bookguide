<?php

declare(strict_types=1);

namespace App\Rules;

use App\Services\AuthorService;
use Illuminate\Contracts\Validation\Rule;

class ExistsUser implements Rule
{
    protected string $authorIds;
    protected AuthorService $authorService;

    public function __construct(
        string $authorIds,
        AuthorService $authorService = null
    ){
        $this->authorIds = $authorIds;
        $this->authorService = $authorService;
    }

    public function passes($attribute, $value): bool
    {
        $valid = $this->authorService->existsAuthorIds(explodeString($this->authorIds));
        if (!$valid){
            return false;
        }

        return true;
    }

    public function message(): string
    {
        return 'Author not found. Try again!';
    }
}
