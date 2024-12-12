<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class ArticleFilter extends Filter
{
    /**
     * Фильтрация по тегу
     *
     * @param string $value
     * @return Builder
     */
    protected function tag(string $value): Builder
    {
        return $this->builder->with('tags')->whereHas('tags', function ($query) use ($value) {
            $query->where('label', $value);
        });
    }
}
