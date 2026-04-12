<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'category_id' => 'required|exists:categories,id',
            'published_year' => 'required|integer|min:1000|max:' . date('Y'),
            'pages' => 'required|integer|min:1',
            'available' => 'boolean',
            'price' => 'required|numeric|min:0',
        ];
    }
}
