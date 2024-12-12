<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class CommentFilter extends Filter
{
    /**
     * Фильтрация по ID статьи
     *
     * @param string $value
     * @return Builder
     */
    protected function articleId(string $value): Builder
    {
        return $this->builder->where('article_id', '=', $value);
    }
}
