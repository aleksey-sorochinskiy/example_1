<?php

namespace App\Http\Requests\Drill;

class UpdateActivityGroup extends BaseDrills
{
    /**
     * Attributes name for validation message
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => 'Activity group name',
        ];
    }
}
