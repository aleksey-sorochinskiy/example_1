<?php

namespace App\Http\Requests\Athlete;

use Illuminate\Foundation\Http\FormRequest;

class StoreAthleteHistoryRequest extends GetAthleteHistorySignificative
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $storeRoles = [
            'value'         => 'required|numeric',
            'created_at'    => 'required|date_format:Y-m-d H:i:s',
            'updated_at'    => 'required|date_format:Y-m-d H:i:s',
        ];

        return array_merge(parent::rules(), $storeRoles);
    }
}
