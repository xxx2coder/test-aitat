<?php

namespace App\Http\Requests\Api\v1\Category;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'name' => ['required', 'string'],
//            'price' => ['required', 'integer'],
//            'quantity' => ['required', 'integer'],
//            'quantity_type' => ['required', 'string'],
//            'category_id' => ['required', 'integer', 'exists:categories,id']
        ];
    }
}
