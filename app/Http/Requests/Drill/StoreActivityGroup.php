<?php

namespace App\Http\Requests\Drill;

class StoreActivityGroup extends UpdateActivityGroup
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = parent::rules();

        $rules = array_merge($rules, ['specific' => 'required|exists:specific_activities,id']);

        return $rules;
    }
}
