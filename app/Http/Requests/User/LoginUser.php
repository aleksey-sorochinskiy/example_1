<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;

class LoginUser extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'login'    => 'required',
            'password' => $this->baseRules['password'],
        ];
    }
}
