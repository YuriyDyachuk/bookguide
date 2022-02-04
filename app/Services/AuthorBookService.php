<?php

declare(strict_types=1);

namespace App\Services;

use App\Factories\AuthorBookFactory;
use App\Repositories\AuthorBookRepository;

class AuthorBookService
{
    protected AuthorBookFactory $authorBookFactory;
    protected AuthorBookRepository $authorBookRepository;

    public function __construct(
        AuthorBookFactory $authorBookFactory,
        AuthorBookRepository $authorBookRepository
    ){
        $this->authorBookFactory = $authorBookFactory;
        $this->authorBookRepository = $authorBookRepository;
    }

    public function attach(int $modelId, array $authorIds): void
    {
        $authorBook = $this->authorBookFactory->create($modelId, $authorIds);
        $this->authorBookRepository->store($authorBook);
    }

    public function detach(int $modelId, int $authorId): void
    {
        $this->authorBookRepository->detach($modelId, $authorId);
    }

    public function destroy(int $bookId): void
    {
        $this->authorBookRepository->destroy($bookId);
    }
}
