<?php

namespace App\Http\Requests\Drill;

class UpdateSetOfExercise extends BaseDrills
{
    /**
     * Attributes name for validation message
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => 'Set of exercise name',
        ];
    }
}
