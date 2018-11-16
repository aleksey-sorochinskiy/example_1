<?php

namespace App\Http\Requests\Athlete;

use App\Http\Requests\BaseRequest;

class UpdateContact extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'              => 'required|string|max:50',
            'relation'          => 'required|string|max:50',
            'email'             => 'nullable|email',
            'phone_code'        => 'required|exists:countries,phone_code',
            'phone_number'      => 'required|between:5,14',
        ];
    }
}
