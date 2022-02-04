<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dashboard\Ajax;

use App\Services\BookService;
use App\Services\AuthorService;
use App\Services\AuthorBookService;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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

    public function destroy(int $bookId, int $authorId): RedirectResponse
    {

        if (!$this->bookService->existsBookId($bookId)
            && !$this->authorService->existsAuthorId($authorId))
        {
            throw new ModelNotFoundException();
        }

        $this->authorBookService->detach($bookId, $authorId);

        return redirect()->back()->with(['message' => 'Successfully detach author for book.'])->withInput();
    }
}
