<?php

declare(strict_types=1);

namespace App\Factories;

use App\DataTransferObjects\AuthorDTO;
use Illuminate\Http\Request;

class AuthorFactory
{
    public function create(Request $request): AuthorDTO
    {
        return new AuthorDTO([
            'surName'       => $request->input('surname'),
            'name'          => $request->input('name'),
            'patronymic'    => $request->input('patronymic')
        ]);
    }
}
