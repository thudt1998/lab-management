<?php

namespace App\Http\Requests;

use App\Rules\EmailFormat;
use Illuminate\Foundation\Http\FormRequest;

class LecturerLoginRequest extends FormRequest
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
            'email' => ['required', 'string', new EmailFormat()],
            'password' => 'required|string'
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'email.required' => trans('validation.email.required'),
            'email.email' => trans('validation.email.type'),
            'password.required' => trans('validation.password.required')
        ];
    }
}
