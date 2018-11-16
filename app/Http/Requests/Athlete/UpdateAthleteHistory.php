<?php

namespace App\Http\Requests\Athlete;

use App\Http\Requests\BaseRequest;

class UpdateAthleteHistory extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'athlete_id'        => 'required|exists:athletes,id',
            'data'              => 'present',
            'data.*.param_name' => 'required|string|max:255',
            'data.*.value'      => 'required|numeric',
            'data.*.created_at' => 'required|date_format:Y-m-d H:i:s',
            'data.*.updated_at' => 'required|date_format:Y-m-d H:i:s',
        ];
    }
}
