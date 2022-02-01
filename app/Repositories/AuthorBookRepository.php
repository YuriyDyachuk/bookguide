<?php

declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class AuthorBookRepository
{
    public function store(array $authorBook): void
    {
        DB::table('author_book')->insert($authorBook);
    }

    public function detach(int $bookId, int $authorId): void
    {
        DB::table('author_book')
            ->where(['book_id' => $bookId, 'author_id' => $authorId])
            ->delete();
    }
}
