<?php

namespace App\Http\Requests\Drill;

class StoreSetOfExercise extends UpdateSetOfExercise
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = parent::rules();

        $rules = array_merge($rules, ['activity' => 'required|exists:activity_groups,id']);

        return $rules;
    }
}
