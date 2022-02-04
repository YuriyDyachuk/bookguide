<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dashboard\Ajax;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\AuthorService;
use App\Factories\AuthorFactory;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthorStoreRequest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AuthorController extends Controller
{
    protected AuthorFactory $authorFactory;
    protected AuthorService $authorService;

    public function __construct(
        AuthorFactory $authorFactory,
        AuthorService $authorService
    ){
        $this->authorFactory = $authorFactory;
        $this->authorService = $authorService;
    }

    public function index(Request $request)
    {
        if($request->ajax()) {
            $books = $this->authorService->searchBook();

            return response(['message' => 'Success', 'data' => $books]);
        }
    }

    public function store(AuthorStoreRequest $request): Response
    {
        if ($request->ajax()) {
            $authorDTO = $this->authorFactory->create($request);
            $author = $this->authorService->store($authorDTO);
        }

        return response(['message' => 'Successfully creating author.', 'data' => $author])->setStatusCode(Response::HTTP_CREATED);
    }

    public function destroy(Request $request, int $authorId): Response
    {
        if ($request->ajax()) {
            if (!$this->authorService->existsAuthorId($authorId)) {
                throw new NotFoundHttpException();
            }
            $this->authorService->destroy($authorId);
        }

        return response(['error' => 'Something went wrong!', 'code' => Response::HTTP_NO_CONTENT]);
    }
}
