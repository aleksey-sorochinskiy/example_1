<?php

namespace App\Http\Requests\User;

use Illuminate\Support\Facades\Auth;

/**
 * Class UserUpdate
 * @package App\Http\Requests\User
 */
class UserUpdate extends BaseUser
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @param null $userId
     * @return array
     */
    public function rules($userId = null)
    {
        $rules = parent::rules($userId);

        $rules['username'] = $rules['username'].',username,'.Auth::id();
        $rules['email'] = $rules['email'].',email,'.Auth::id();

        return $rules;
    }
}