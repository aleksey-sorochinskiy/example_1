<?php

namespace App\Http\Requests\Drill;

class StoreSpecificActivity extends UpdateSpecificActivity
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = parent::rules();

        $rules = array_merge($rules, [
            'type' => 'required|exists:type_of_trainings,id',
            'user_id' => 'exists:users,id'
        ]);

        return $rules;
    }
}
