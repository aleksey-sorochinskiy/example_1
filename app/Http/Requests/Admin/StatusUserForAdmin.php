<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\User\BaseUser;

class StatusUserForAdmin extends BaseUser
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'status' => 'required|numeric|in:0,1'
        ];
    }
}
