<?php

namespace App\Http\Requests;

use App\Rules\EmailFormat;
use Illuminate\Foundation\Http\FormRequest;

class LecturerCreateRequest extends FormRequest
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
            'name' => 'required|max:50',
//            'email' => ['required', 'unique:lecturers,email', new EmailFormat()],
            'subject' => 'required'
        ];
    }
}
