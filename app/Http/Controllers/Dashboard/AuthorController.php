<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dashboard;

use App\Services\AuthorService;
use App\Factories\AuthorFactory;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\AuthorUpdateRequest;
use Illuminate\Support\Facades\DB;
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

    public function index()
    {
        return view('authors.index', ['authors' => $this->authorService->getAll()]);
    }

    public function show(int $authorId)
    {
        if (!$this->authorService->existsAuthorId($authorId)) {
            throw new NotFoundHttpException();
        }

        return view('authors.show', ['author' => $this->authorService->findById($authorId)]);
    }

    public function update(AuthorUpdateRequest $request, int $authorId): RedirectResponse
    {
        if (!$this->authorService->existsAuthorId($authorId)) {
            throw new NotFoundHttpException();
        }

        DB::beginTransaction();
        try {
            $DTO = $this->authorFactory->create($request);
            $this->authorService->update($DTO, $authorId);
            DB::commit();

        }catch (\Throwable $exception) {
            DB::rollBack();

            return redirect()->back()->withErrors(['error' => 'Something went wrong!']);
        }

        return redirect()->back()->withInput(['message' => 'Successfully updating author.']);
    }
}
