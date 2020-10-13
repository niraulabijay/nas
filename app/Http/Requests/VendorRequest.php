<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VendorRequest extends FormRequest
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
            // 'name' => 'required|max:255',
            // 'primary_email' => 'required|string',
            'primary_phone' => 'required|min:7|max:13',
            // 'address' => 'required',
            // 'title' => 'required',
            // 'image' => 'image|mimes:jpeg,jpg,png,gif,svg|max:2048',
            'description' => 'required',
            // 'categories' => 'required'
        ];
    }
}
