<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;
use Illuminate\Support\Facades\Auth;

/**
 * Class BaseUser
 * @package App\Http\Requests\User
 */
class BaseUser extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @param null $userId
     * @return array
     */
    public function rules($userId = null)
    {
        if (Auth::user() && !Auth::user()->isAdmin()){
            $userId = Auth::id();
        }

        return [
            'username'     => 'required|max:100|unique:users',
            'email'        => 'required|email|confirmed|unique:users',
            'password'     => 'nullable|min:6|confirmed',
            'first_name'   => 'required|max:50',
            'last_name'    => 'required|max:50',
            'birthdate'    => 'required|date|before:now',
            'country'      => 'nullable|string',
            'zip'          => 'nullable|max:12',
            'phone_code'   => 'nullable|numeric',
            'phone_number' => 'nullable|numeric|digits_between:5,14|unique:users,phone_number,'.$userId.',id,phone_code,'.$this->request->get('phone_code', 'null'),
            'home_club'    => 'nullable|string',
            'job_title'    => 'nullable|string',
            'photo'        => 'nullable|string',
            'photo_file'   => 'nullable|image|mimes:jpeg,gif,png|max:6144'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'photo_file.uploaded' => 'Maximum allowed size of the image is 6 Mb',
            'username.unique'     => 'User with the entered username already exists',
        ];
    }
}
