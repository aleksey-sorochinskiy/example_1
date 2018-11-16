<?php

namespace App\Http\Requests\Athlete;

use App\Athlete;
use App\Http\Requests\BaseRequest;
use Illuminate\Support\Facades\Auth;

class StoreAthlete extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules($athleteId = 'null')
    {
        $phoneCode = $this->request->has(  'phone_code')?$this->request->get('phone_code'):'null';
        $coachId = Auth::id();

        return [
            'first_name'                => 'required|max:50',
            'last_name'                 => 'required|max:50',
            'gender'                    => 'required',
            'coach_name'                => 'required|max:50',
            'birthdate'                 => 'required|date|before:now',
            'birthplace'                => 'max:100',
            'citizenship'               => 'max:100',
            'residence'                 => 'max:100',
            'address'                   => 'max:150',
            'phone_code'                => 'required|exists:countries,phone_code',
            'phone_number'              => "required|between:5,14|unique:athletes,phone_number,{$athleteId},id,phone_code,{$phoneCode},coach_id,{$coachId}",
            'email'                     => "email|max:255|unique:athletes,email,{$athleteId},id,coach_id,{$coachId}",
            'contact'                   => 'present',
            'contact.name'              => 'required_if:contact,filled|string|max:50',
            'contact.relation'          => 'required_if:contact,filled|string|max:50',
            'contact.email'             => 'nullable|email',
            'contact.country_id'        => 'required_if:contact,filled|exists:countries,id',
            'contact.phone_number'      => 'required_if:contact,filled|between:5,14',
            'biometric'                 => 'present',
            'biometric.weight'          => 'required_if:biometric,filled',
            'biometric.height'          => 'required_if:biometric,filled',
            'biometric.rest_hr'         => 'numeric',
            'biometric.hr_max'          => 'required_if:biometric,filled',
            'biometric.note'            => 'max:200',
            'biometric.blood_type'      => 'in:'.implode(",", Athlete::BLOOD_TYPE),
            'technical'                 => 'present',
            'technical.ranking'         => 'max:50',
            'technical.plays_hand'      => 'required_if:technical,filled',
            'technical.plays_backhand'  => 'required_if:technical,filled',
            'technical.racket'          => 'max:50',
            'technical.strings'         => 'max:50',
            'technical.stringing'       => 'max:50',
            'technical.note'            => 'max:200',
            'medical'                   => 'present',
            'medical.physicians'        => 'max:100',
            'medical.physio'            => 'max:100',
            'medical.allergies'         => 'max:200',
            'medical.other'             => 'max:200',
            'img'                       => 'nullable|string',
            'img_file'                  => 'nullable|image|mimes:jpeg,gif,png|max:6144'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'img.size'                  => 'Maximum allowed size of the image is 6 Mb',
            'country_id.required'       => 'Select country code',
            'contact.country.required'  => 'Select country code',
            'phone_number.required'     => 'Enter phone number',
            'unique'                    => 'Athlete with the entered :attribute already exists in your list',
        ];
    }

    /**
     * Attributes name for validation message
     *
     * @return array
     */
    public function attributes()
    {
        $rules = parent::attributes();
        $rules['email'] = 'email address';

        return $rules;
    }
}
