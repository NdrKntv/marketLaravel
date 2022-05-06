<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function deleted()
    {
        return $this->product->images()->whereIn('id', $this->get('delete_image') ?? []);
    }

    public function rules()
    {
        return [
            'main_image' => ['nullable', 'integer', 'exists:images,id,product_id,' . $this->product->id],
            'delete_image' => 'array|nullable',
            'delete_image.*' => ['nullable', 'integer', 'exists:images,id,product_id,' . $this->product->id],
            'tags' => 'array|nullable|max:4',
            'tags.*' => 'integer|nullable|distinct',
            'image' => 'array|nullable|max:' . (8 - $this->product->images()->count() + count($this->get('delete_image')??[])),
            'image.*' => 'image|nullable|distinct',
            'title' => 'string|required|max:50|min:2',
            'price' => 'integer|required',
            'description' => 'string|required|max:1500',
            'in_stock' => 'string',
            'newness' => 'int|nullable|in:0,1',
            'active' => 'int|nullable|in:0,1'
        ];
    }

    public function prepareForValidation()
    {
        $this->mergeIfMissing(['newness' => 1, 'active' => 1]);
    }
}
