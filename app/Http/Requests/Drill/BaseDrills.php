<?php

namespace App\Http\Requests\Drill;

use App\Http\Requests\BaseRequest;

class BaseDrills extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:20'
        ];
    }
}
