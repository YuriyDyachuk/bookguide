<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dashboard;

use App\Services\AuthorService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AuthorController extends Controller
{
    protected AuthorService $authorService;

    public function __construct(AuthorService $authorService)
    {
        $this->authorService = $authorService;
    }

    public function index()
    {
        return view('authors.index', ['authors' => $this->authorService->getAll()]);
    }

    public function destroy(int $authorId): RedirectResponse
    {
        if (!$this->authorService->existsAuthorId($authorId)) {
            throw new NotFoundHttpException();
        }

        DB::beginTransaction();
        try {
            $this->authorService->destroy($authorId);

            return redirect()->back()->withInput(['message' => 'Successfully deleting author.']);
        }catch (\Throwable $exception) {
            DB::rollBack();

            return redirect()->back()->withErrors(['error' => 'Something went wrong!']);
        }
    }
}
