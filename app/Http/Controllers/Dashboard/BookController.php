<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dashboard;

use App\Services\BookService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use App\Services\MediaService;
use App\Factories\BookFactory;
use Illuminate\Support\Facades\DB;
use App\Services\AuthorBookService;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookUpdateRequest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BookController extends Controller
{
    protected BookFactory $bookFactory;
    protected BookService $bookService;
    protected MediaService $mediaService;
    protected AuthorBookService $authorBookService;

    public function __construct(
        BookFactory $bookFactory,
        BookService $bookService,
        MediaService $mediaService,
        AuthorBookService $authorBookService
    ){
        $this->bookFactory = $bookFactory;
        $this->bookService = $bookService;
        $this->mediaService = $mediaService;
        $this->authorBookService = $authorBookService;
    }

    public function index()
    {
        return view('books.index', ['books' => $this->bookService->getAll()]);
    }

    public function show(int $bookId)
    {
        if (!$this->bookService->existsBookId($bookId)) {
            throw new NotFoundHttpException();
        }

        return view('books.show', ['book' => $this->bookService->findById($bookId)]);
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
            $this->mediaService->updateMedia($book, $request->file('media'));
            DB::commit();

        }catch (\Throwable $exception) {
            DB::rollBack();

            return redirect()->back()->withErrors(['error' => 'Something went wrong!']);
        }

        return redirect()->back()->withInput(['message' => 'Successfully updating book.']);
    }
}
