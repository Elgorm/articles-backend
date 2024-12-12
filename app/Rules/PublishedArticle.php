<?php

namespace App\Rules;

use App\Models\Article;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PublishedArticle implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!Article::published()->where('id', $value)->exists()) {
            $fail('Статья с указанным ID не найдена или не опубликована.');
        }
    }
}
