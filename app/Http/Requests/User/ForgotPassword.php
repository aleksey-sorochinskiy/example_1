<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;

class ForgotPassword extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => $this->baseRules['email'],
            'password' => $this->baseRules['conf_password'],
            'token' => 'required|string'
        ];
    }
}
