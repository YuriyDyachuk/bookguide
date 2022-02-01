<?php

declare(strict_types=1);

namespace App\Factories;

use Illuminate\Http\Request;
use App\DataTransferObjects\BookDTO;

class BookFactory
{
    public function create(Request $request): BookDTO
    {
        return new BookDTO([
            'name'          => $request->input('name'),
            'description'   => $request->input('description'),
            'published'     => changeTypeDate($request->input('published'))
        ]);
    }
}
