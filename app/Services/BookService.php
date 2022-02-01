<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Book;
use App\DataTransferObjects\BookDTO;
use App\Repositories\BookRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class BookService
{
    protected AuthorBookService $authorBookService;
    protected BookRepository $bookRepository;

    public function __construct(
        AuthorBookService $authorBookService,
        BookRepository $bookRepository
    ){
        $this->authorBookService = $authorBookService;
        $this->bookRepository = $bookRepository;
    }

    public function getAll(): LengthAwarePaginator
    {
        return $this->bookRepository->getAll();
    }

    public function store(BookDTO $DTO): Book
    {
        return $this->bookRepository->create($DTO);
    }

    public function update(BookDTO $DTO, int $bookId): void
    {
        $this->bookRepository->update($DTO, $bookId);
    }

    public function destroy(int $bookId): void
    {
        $this->bookRepository->destroy($bookId);
    }

    #================================== [CUSTOM METHODS] ==================================#

    public function findById(int $bookId): ?Book
    {
        return $this->bookRepository->findById($bookId);
    }

    public function existsBookId(int $bookId): bool
    {
        return $this->bookRepository->existsById($bookId);
    }
}
