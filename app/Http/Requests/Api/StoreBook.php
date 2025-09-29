<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StoreBook extends FormRequest
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
    
        $rules = [
            'data.attributes.title' => 'required|string',
            'data.attributes.author' => 'required|string',
            'data.attributes.description' => 'required|string',
            'data.attributes.published_year' => 'required|integer',
            'data.attributes.is_published' => 'required|boolean',
        ];

        if ($this->routeIs('books.store')) {
            $rules['data.relationships.user_id'] = 'required|exists:users,id';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'data.attributes.title.required' => 'The title field is required.',
            'data.attributes.author.required' => 'The author field is required.',
            'data.attributes.description.required' => 'The description field is required.',
            'data.attributes.published_year.required' => 'The published_year field is required.',
            'data.relationships.user_id.required' => 'The user_id field is required.',
            'data.attributes.is_published.required' => 'The is_published field is required.',
        ];
    }
}
