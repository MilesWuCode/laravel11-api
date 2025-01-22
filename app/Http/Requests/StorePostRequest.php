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
            // 標題
            'title' => 'required|string|max:100',
            // 內文
            'description' => 'nullable|string',
            // 封面
            'cover' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:512',
            // 最多5個, 每個圖片最大512kb
            'images' => 'array|max:5',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:512',
        ];
    }
}
