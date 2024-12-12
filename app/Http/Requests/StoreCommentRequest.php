<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\PublishedArticle;

class StoreCommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'article_id' => ['required', 'numeric', new PublishedArticle],
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'article_id.required' => 'Тема должна быть заполнена.',
            'article_id.exists' => 'Такой статьи нет',
            'subject.required' => 'Тема должна быть заполнена.',
            'body.required' => 'Содержимое должно быть заполнено.',
        ];
    }
}
