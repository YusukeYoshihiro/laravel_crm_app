<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class FilterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // return ($this->path() === 'customers');
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
            'searchId' => [
                'nullable',
                'numeric',
            ],
            // 'course_end_at' => [
            //     'nullable',
            //     'date',
            // ],
            // 'seminar_state' => [
            //     'nullable',
            //     'array',
            // ],
            // 'any_name' => [
            //     'nullable',
            //     'string',
            //     'max:50',
            // ],
        ];
    }

    // public function attributes()
    // {
    //     return __('messages.seminar.search.attributes');
    // }
}
