<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Author;
use App\Enums\PaginateEnum;
use App\Filters\Author\Search;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Collection;
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
        return $this->query()->paginate(PaginateEnum::countPage()->value);
    }

    public function create(AuthorDTO $DTO): Author
    {
        return $this->query()->create($DTO->toArray())->refresh();
    }

    public function update(AuthorDTO $DTO, int $authorId): void
    {
        $this->query()
             ->where('id', $authorId)
             ->update($DTO->toArray());
    }

    public function destroy(int $authorId): void
    {
        $this->query()->where('id', $authorId)->delete();
    }

    #================================== [CUSTOM METHODS] ==================================#

    public function all(): Collection
    {
        return $this->query()->get();
    }

    public function searchBook(): Collection
    {
        return $this->search()->get();
    }

    public function findById(int $authorId): ?Author
    {
        return $this->query()->where('id', $authorId)->first();
    }

    public function existsById(int $authorId): bool
    {
        return $this->query()->where('id', $authorId)->exists();
    }

    public function existsIds(array $ids): bool
    {
        return $this->query()->whereIn('id', $ids)->exists();
    }
}
