<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dashboard\Ajax;

use App\Services\BookService;
use Illuminate\Http\Response;
use App\Services\AuthorService;
use App\Services\AuthorBookService;
use App\Http\Controllers\Controller;

class AuthorBookDetachController extends Controller
{
    protected BookService $bookService;
    protected AuthorService $authorService;
    protected AuthorBookService $authorBookService;

    public function __construct(
        BookService $bookService,
        AuthorService $authorService,
        AuthorBookService $authorBookService
    ){
        $this->bookService = $bookService;
        $this->authorService = $authorService;
        $this->authorBookService = $authorBookService;
    }

    public function destroy(int $bookId, int $authorId): Response
    {
        if (!$this->bookService->existsBookId($bookId)
            && !$this->authorService->existsAuthorId($authorId))
        {
            $this->authorBookService->detach($bookId, $authorId);
        }

        return response(['message' => 'Successfully detach author for book.']);
    }
}
