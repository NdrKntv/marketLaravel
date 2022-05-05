<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'tags' => 'array|nullable|max:4',
            'tags.*' => 'integer|nullable|distinct',
            'image' => 'array|nullable|max:8',
            'image.*' => 'image|nullable|distinct',
            'title' => 'string|required|max:50|min:2',
            'price' => 'integer|required',
            'description' => 'string|required|max:1500',
            'in_stock' => 'string',
            'newness' => 'int|nullable',
            'active' => 'int|nullable',
            'category_id'=>'int|exists:categories,id'
        ];
    }

    public function passedValidation()
    {
        $this->merge(['user_id' => $this->user()->id, 'slug' => '']);
    }
}
