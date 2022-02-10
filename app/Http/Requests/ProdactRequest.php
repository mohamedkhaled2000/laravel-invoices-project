<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProdactRequest extends FormRequest
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
            'prodact_name' => 'required|max:100|unique:prodacts,prodact_name',
            'description' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'prodact_name.required' => 'يرجى ادخال اسم المنتج',
            'prodact_name.unique' => 'اسم المنتج مدخل مسبقا',
            'description.required' => 'يرجى ادخال تفاصيل المنتج'
        ];
    }
}
