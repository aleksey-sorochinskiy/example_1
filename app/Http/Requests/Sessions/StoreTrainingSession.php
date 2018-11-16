<?php

namespace App\Http\Requests\Sessions;

class StoreTrainingSession extends UpdateTrainingSession
{
    /**
     * Required inputs array
     *
     * @var array
     */
    protected $required_inputs = ['location', 'assign', 'time_start', 'time_end'];

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
