<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Enums\PaginateEnum;
use App\Filters\Author\Search;
use App\Filters\Author\SurName;
use App\Models\Author;
use Illuminate\Pipeline\Pipeline;
use App\DataTransferObjects\AuthorDTO;
use Illuminate\Pagination\LengthAwarePaginator;

class AuthorRepository extends AbstractRepository
{
    public function model(): string
    {
        return Author::class;
    }

    private function search()
    {
        return app(Pipeline::class)
            ->send(self::query())
            ->through([
                Search::class
            ])->thenReturn();
    }

    public function getAll(): LengthAwarePaginator
    {
        return $this->search()->paginate(PaginateEnum::countPage()->value);
    }

    public function create(AuthorDTO $DTO): void
    {
        $this->query()->create($DTO->toArray())->refresh();
    }

    public function update(AuthorDTO $DTO, int $authorId): void
    {
        $this->query()
             ->where(['id' => $authorId])
             ->update($DTO->toArray());
    }

    public function destroy(int $authorId): void
    {
        $this->query()->where(['id' => $authorId])->delete();
    }

    #================================== [CUSTOM METHODS] ==================================#

    public function findById(int $authorId): ?Author
    {
        return $this->query()->where(['id' => $authorId])->first();
    }

    public function existsById(int $authorId): bool
    {
        return $this->query()->where(['id' => $authorId])->exists();
    }
}
