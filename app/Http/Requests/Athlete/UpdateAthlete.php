<?php

namespace App\Http\Requests\Athlete;

class UpdateAthlete extends StoreAthlete
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @param string $athleteId
     * @return array
     */
    public function rules($athleteId = 'null')
    {
        $athleteId = $this->getLastPathElement();;

        return parent::rules($athleteId);
    }
}
