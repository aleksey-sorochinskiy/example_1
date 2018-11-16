<?php

namespace App\Http\Requests\User;


class UserRegister extends BaseUser
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'required|max:100|unique:users',
            'email'    => $this->baseRules['email'].'|unique:users',
            'password' => $this->baseRules['password']
        ];
    }
}
