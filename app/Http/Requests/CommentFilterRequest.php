<?php

namespace App\Http\Requests;

use App\Rules\PublishedArticle;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ProductFilterRequest
 */
class CommentFilterRequest extends FormRequest
{
    /**
     * Правила валидации
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'article_id' => ['numeric', new PublishedArticle],
        ];
    }
}
