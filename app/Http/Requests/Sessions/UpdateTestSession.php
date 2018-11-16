<?php

namespace App\Http\Requests\Sessions;

class UpdateTestSession extends BaseSessionRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            'name'      => 'string|max:255',
            'athlete_id'=> 'exists:athletes,id',
        ]);
    }
}
