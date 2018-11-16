<?php

namespace App\Http\Requests\Sessions;

class StoreOtherEvent extends UpdateOtherEvent
{
    /**
     * Required inputs array
     *
     * @var array
     */
    protected $required_inputs = ['location', 'summary', 'time_start', 'time_end'];

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
