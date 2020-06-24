<?php

namespace App\Http\Requests;

use App\Rules\PeriodExist;
use Illuminate\Foundation\Http\FormRequest;

class ProjectCreateRequest extends FormRequest
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
            'compartment_id' => ['required'],
            'date_start' => ['required', 'date'],
            'date_finish' => ['required',
                'date',
                'after_or_equal:date_start',
                new PeriodExist(null, $this->request->get('compartment_id'), $this->request->get('date_start'))]
        ];
    }
}
