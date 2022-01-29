<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dashboard\Ajax;

use Illuminate\Http\Response;
use App\Services\AuthorService;
use App\Factories\AuthorFactory;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthorStoreRequest;
use App\Http\Requests\AuthorUpdateRequest;
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

    public function store(AuthorStoreRequest $request): Response
    {
        if ($request->ajax()) {
            $authorDTO = $this->authorFactory->create($request);
            $this->authorService->store($authorDTO);
        }

        return response(['message' => 'Successfully creating author.'])->setStatusCode(Response::HTTP_CREATED);
    }

    public function update(AuthorUpdateRequest $request, int $authorId): Response
    {
        if ($request->ajax()) {
            if (!$this->authorService->existsAuthorId($authorId)) {
                throw new NotFoundHttpException();
            }

            $authorDTO = $this->authorFactory->create($request);
            $this->authorService->update($authorDTO, $authorId);
        }

        return response(['message' => 'Successfully updating author.']);
    }
}
