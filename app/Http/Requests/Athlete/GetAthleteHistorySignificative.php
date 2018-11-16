<?php

namespace App\Http\Requests\Athlete;

use App\Http\Requests\BaseRequest;

class GetAthleteHistorySignificative extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'athlete_id' => 'required|exists:athletes,id',
            'param_name' => 'required|string|max:255'
        ];
    }
}
