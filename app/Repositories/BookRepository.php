<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Book;
use App\Enums\PaginateEnum;
use App\DataTransferObjects\BookDTO;
use Illuminate\Pagination\LengthAwarePaginator;

class BookRepository extends AbstractRepository
{
    public function model(): string
    {
        return Book::class;
    }

    public function getAll(): LengthAwarePaginator
    {
        return $this->query()->paginate(PaginateEnum::countPage()->value);
    }

    public function create(BookDTO $DTO): Book
    {
        return $this->query()->create($DTO->toArray())->refresh();
    }

    public function update(BookDTO $DTO, int $bookId): void
    {
        $this->query()
             ->where(['id' => $bookId])
             ->update($DTO->toArray());
    }

    public function destroy(int $bookId): void
    {
        $this->query()->where(['id' => $bookId])->delete();
    }

    #================================== [CUSTOM METHODS] ==================================#

    public function findById(int $bookId): ?Book
    {
        return $this->query()->where(['id' => $bookId])->first();
    }

    public function existsById(int $bookId): bool
    {
        return $this->query()->where(['id' => $bookId])->exists();
    }
}
