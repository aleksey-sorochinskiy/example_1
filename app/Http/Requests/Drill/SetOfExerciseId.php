<?php

namespace App\Http\Requests\Drill;

use App\Http\Requests\BaseRequest;

class SetOfExerciseId extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'set_of_exercise_id' => 'required|exists:set_of_exercises,id'
        ];
    }
}
