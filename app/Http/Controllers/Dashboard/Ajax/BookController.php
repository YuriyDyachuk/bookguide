<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dashboard\Ajax;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\BookService;
use App\Services\MediaService;
use App\Factories\BookFactory;
use App\Services\AuthorBookService;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\BookStoreRequest;
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

    public function store(BookStoreRequest $request): Response
    {
        $book = null;
        if ($request->ajax()) {
            try {
                $DTO = $this->bookFactory->create($request);
                $book = $this->bookService->store($DTO);
                /* Attach authors for book */
                $this->authorBookService->attach($book->id, explodeString($request->input('authorIds')));
                /* Add media file for book */
                $this->mediaService->storeMedia($book, $request->file('media'));
            }catch (\Throwable $exception) {
                return response(['error' => $exception->getMessage(), 'code' => Response::HTTP_BAD_REQUEST]);
            }
        }

        return response(['message' => 'Successfully creating book.', 'data' => $book])->setStatusCode(Response::HTTP_CREATED);
    }

    public function destroy(Request $request, int $bookId): RedirectResponse
    {
        if ($request->ajax()) {
            if (!$this->bookService->existsBookId($bookId)) {
                throw new NotFoundHttpException();
            }

            try {
                $book = $this->bookService->findById($bookId);
                $this->mediaService->deleteMedia($book);
                $this->bookService->destroy($bookId);

                return redirect()->back()->withInput(['message' => 'Successfully deleting book.']);
            }catch (\Throwable $exception) {
                return redirect()->back()->withErrors(['error' => 'Something went wrong!']);
            }
        }
    }
}
