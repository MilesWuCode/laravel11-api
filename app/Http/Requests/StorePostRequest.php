<?php

namespace App\Http\Requests;

use App\Models\Post;
use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', Post::class);

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:100',
            'description' => 'nullable|string',
            'cover' => 'image|mimes:jpg,jpeg,png,webp|max:512',
            // * 最多5個
            'images' => 'required|array|max:5',
            // * 每個圖片最大512kb
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:512',
        ];
    }
}
