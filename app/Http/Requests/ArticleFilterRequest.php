<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ProductFilterRequest
 */
class ArticleFilterRequest extends FormRequest
{
    /**
     * Правила валидации
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'tag' => 'nullable|string|max:255',
        ];
    }
}
