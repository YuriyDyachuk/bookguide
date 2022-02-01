<?php

declare(strict_types=1);

namespace App\Factories;

use Illuminate\Http\Request;
use App\DataTransferObjects\AuthorDTO;

class AuthorFactory
{
    public function create(Request $request): AuthorDTO
    {
        return new AuthorDTO([
            'surname'       => $request->input('surname'),
            'name'          => $request->input('name'),
            'patronymic'    => $request->input('patronymic')
        ]);
    }
}
