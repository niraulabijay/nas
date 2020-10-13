<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name' => 'required|max:255',
            'product_price' => 'required|numeric',
            'brand_id' => 'required',
            'category_id' => 'required',
        ];
    }
    
    public function messages(){
        return [
        'name.required' => 'Product name field is empty.',
        'product_price.required'  => 'Please enter your product price',
        'category_id.required'  => 'Please select the category',
    ];
    }
}
