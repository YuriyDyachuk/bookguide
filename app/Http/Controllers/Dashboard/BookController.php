<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dashboard;

use App\Services\BookService;
use App\Services\MediaService;
use App\Factories\BookFactory;
use App\Services\AuthorService;
use Illuminate\Support\Facades\DB;
use App\Services\AuthorBookService;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\BookUpdateRequest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BookController extends Controller
{
    protected BookFactory $bookFactory;
    protected BookService $bookService;
    protected MediaService $mediaService;
    protected AuthorService $authorService;
    protected AuthorBookService $authorBookService;

    public function __construct(
        BookFactory $bookFactory,
        BookService $bookService,
        MediaService $mediaService,
        AuthorService $authorService,
        AuthorBookService $authorBookService
    ){
        $this->bookFactory = $bookFactory;
        $this->bookService = $bookService;
        $this->mediaService = $mediaService;
        $this->authorService = $authorService;
        $this->authorBookService = $authorBookService;
    }

    public function index()
    {
        $books = $this->bookService->getAll();
        $authors = $this->authorService->all()->pluck('name','id');

        return view('books.index', [
                    'books' => $books,
                    'authors' => $authors
                ]);
    }

    public function show(int $bookId)
    {
        if (!$this->bookService->existsBookId($bookId)) {
            throw new NotFoundHttpException();
        }
        $book = $this->bookService->findById($bookId);

        return view('books.show', [
            'book' => $book,
            'media' => $book->media()->first()
            ]);
    }

    public function edit(int $bookId)
    {
        $authors = [];

        if (!$this->bookService->existsBookId($bookId)) {
            throw new NotFoundHttpException();
        }

        $book = $this->bookService->findById($bookId);
        $author = $this->authorService->all();
        if (!$author->isEmpty()) {
            $authors = $this->authorService->filterAuthorWithSelect($book, $author);
        }

        return view('books.edit', [
                    'book' => $book,
                    'authors' => $authors,
                    'media' => $book->media()->first()
                ]);
    }

    public function update(BookUpdateRequest $request, int $bookId): RedirectResponse
    {
        if (!$this->bookService->existsBookId($bookId)) {
            throw new NotFoundHttpException();
        }

        DB::beginTransaction();
        try {
            $bookDTO = $this->bookFactory->create($request);
            $this->bookService->update($bookDTO, $bookId);
            $book = $this->bookService->findById($bookId);
            if (!is_null($request->input('authors'))) {
                $this->authorBookService->attach($bookId, $request->input('authors'));
            }
            if (!empty($request->file('media'))) {
                $this->mediaService->updateMedia($book, $request->file('media'));
            }
            DB::commit();

        }catch (\Throwable $exception) {
            DB::rollBack();

            return redirect()->back()->withErrors(['error' => 'Something went wrong!']);
        }

        return redirect()->back()->withInput(['message' => 'Successfully updating book.']);
    }
}
