<?php

namespace App\Http\Requests\Drill;

class UpdateSpecificActivity extends BaseDrills
{
    /**
     * Attributes name for validation message
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => 'Specific activity name',
        ];
    }
}
