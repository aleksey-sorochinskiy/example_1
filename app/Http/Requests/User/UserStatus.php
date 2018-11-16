<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;

class UserStatus extends BaseRequest
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
