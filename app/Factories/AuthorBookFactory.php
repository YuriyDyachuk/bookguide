<?php

declare(strict_types=1);

namespace App\Factories;

class AuthorBookFactory
{
    public function create(int $modelId, array $authorIds): array
    {
        $data = [];
        foreach ($authorIds as $key => $id) {
            $data[$key]['book_id'] = $modelId;
            $data[$key]['author_id'] = $id;
        }

        return $data;
    }
}
