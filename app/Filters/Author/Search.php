<?php

declare(strict_types=1);

namespace App\Filters\Author;

use App\Filters\Filter;

class Search extends Filter
{
    protected function applyFilter($builder)
    {
        return $builder
                    ->where('name', 'LIKE', '%' .request($this->filterName()). '%')
                    ->orWhere('surname', 'LIKE', '%' .request($this->filterName()). '%');
    }
}
