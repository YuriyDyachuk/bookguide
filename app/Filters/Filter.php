<?php

namespace App\Filters;

use Closure;
use Illuminate\Support\Str;

abstract class Filter
{
    /**
     * @param $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $search = request()->has($this->filterName());
        if (!$search) {
            return $next($request);
        }

        $builder = $next($request);
        return $this->applyFilter($builder);
    }

    /**
     * @param $builder
     */
    protected abstract function applyFilter($builder);

    /**
     * @return string
     */
    protected function filterName(): string
    {
        return Str::snake(class_basename($this));
    }
}
