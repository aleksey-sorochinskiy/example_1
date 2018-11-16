<?php

namespace App\Http\Requests\Sessions;

class StoreTestSession extends UpdateTestSession
{
    /**
     * Required inputs array
     *
     * @var array
     */
    protected $required_inputs = ['location', 'name', 'time_start', 'time_end', 'athlete_id'];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->doRequired(parent::rules());
    }
}
