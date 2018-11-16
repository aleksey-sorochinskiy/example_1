<?php

namespace App\Http\Requests\Sessions;

class CompletedSessions extends CompletedTestSession
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return array_merge([
            'assessment' => 'required|numeric|max:5',
        ], parent::rules());
    }
}
