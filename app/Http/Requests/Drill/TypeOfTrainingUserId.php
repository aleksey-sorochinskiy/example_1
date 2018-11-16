<?php

namespace App\Http\Requests\Drill;

use App\Http\Requests\BaseRequest;

class TypeOfTrainingUserId extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'exists:users,id'
        ];
    }
}
