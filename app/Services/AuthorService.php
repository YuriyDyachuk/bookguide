<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Author;
use App\Repositories\AuthorRepository;
use App\DataTransferObjects\AuthorDTO;
use Illuminate\Pagination\LengthAwarePaginator;

class AuthorService
{
    protected AuthorBookService $authorBookService;
    protected AuthorRepository $authorRepository;

    public function __construct(
        AuthorBookService $authorBookService,
        AuthorRepository $authorRepository
    ){
        $this->authorBookService = $authorBookService;
        $this->authorRepository = $authorRepository;
    }

    public function getAll(): LengthAwarePaginator
    {
        return $this->authorRepository->getAll();
    }

    public function store(AuthorDTO $DTO)
    {
        $this->authorRepository->create($DTO);
    }

    public function update(AuthorDTO $DTO, int $authorId)
    {
        $this->authorRepository->update($DTO, $authorId);
    }

    public function destroy(int $authorId): void
    {
        $this->authorRepository->destroy($authorId);
    }

    #================================== [CUSTOM METHODS] ==================================#

    public function findById(int $authorId): ?Author
    {
        return $this->authorRepository->findById($authorId);
    }

    public function existsAuthorId(int $authorId): bool
    {
        return $this->authorRepository->existsById($authorId);
    }
}
