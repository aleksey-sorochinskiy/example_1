<?php

namespace App\Http\Requests\Sessions;

class UpdateTrainingSession extends BaseSessionRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            'assign'                    => 'array',
            'assign.*'                  => 'exists:athletes,id',
            'training_session_card_id'  => '',
        ]);
    }
}
