<?php

namespace App\Http\Requests\Sessions;

use Illuminate\Foundation\Http\FormRequest;

class BaseSessionRequest extends FormRequest
{
    /**
     * Required inputs array
     *
     * @var array
     */
    protected $required_inputs = [];
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'location'                  => 'string|max:255',
            'time_start'                => 'date_format:Y-m-d H:i:s',
            'time_end'                  => 'date_format:Y-m-d H:i:s',
            'note'                      => 'nullable|string|max:200',
            'alert_period'              => 'nullable|numeric|in:0,5,15,30,60,120,1440,2880,10080',
            'repeat_period'             => 'nullable|numeric|in:0,1,7,14,30,365',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'assign.required' => 'Select athlete to assign the test session to',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'location'      => 'Location',
            'note'          => 'Note',
            'time_start'    => 'Time start',
            'time_end'      => 'Time end',
            'alert_period'  => 'Alert',
            'repeat_period' => 'Repeat',
        ];
    }

    /**
     * Do input is required
     *
     * @return mixed
     */
    protected function doRequired($rules)
    {
        foreach ($this->required_inputs as $input){
            $rules[$input] = 'required|'.$rules[$input];
        }

        return $rules;
    }
}
