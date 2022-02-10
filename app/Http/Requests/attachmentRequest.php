<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class attachmentRequest extends FormRequest
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
            'pic' => 'required|mimes:png,jpg,pdf,jpeg'
        ];
    }
    public function messages(){
        return [
            'pic.required' => 'يرجى اختار المرفق',
            'pic.mimes' => 'صيغة المرفق يجب ان تكون png,jpg.pdf,jpeg '
        ];
    }
}
