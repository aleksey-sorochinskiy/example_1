<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BaseRequest extends FormRequest
{
    /**
     * Basic rules for frequently used fields
     *
     * @var array
     */
    protected $baseRules = [
        'email' => 'required|email|max:255',
        'conf_password' => 'required|string|confirmed|min:6',
        'password' => 'required|string|min:6'
    ];

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
     * Return last part of url path
     * @return mixed
     */
    protected function getLastPathElement()
    {
        $pathArray = explode("/", $this->path());
        return $pathArray[count($pathArray)-1];
    }

    /**
     * Attributes name for validation message
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'username'  => 'Username',
            'email'     => 'Email address',
            'password'  => 'Password',
            'photo_file'=> 'Image',
            'first_name'=> 'First Name',
            'last_name' => 'Last Name',
            'birthdate' => 'Birthdate',
            'zip'       => 'Zip',
            'img'           => 'Image',
            'coach_name'    => 'Coach Name',
            'gender'        => 'Gender',
            'birthplace'    => 'Birthplace',
            'citizenship'   => 'Citizenship',
            'residence'     => 'Residence',
            'address'       => 'Address',
            'phone_number'  => 'Phone Number',
            'name'          => 'Name',
            'relation'      => 'Relation',
            'weight'        => 'Weight',
            'height'        => 'Height',
            'hr_max'        => 'HR Max',
            'note'          => 'Note',
            'ranking'       => 'Ranking',
            'racket'        => 'Racket',
            'strings'       => 'Strings',
            'stringing'     => 'Stringing',
            'physicians'    => 'Physicians',
            'physio'        => 'Physio',
            'allergies'     => 'Allergies',
            'other'         => 'Other',
        ];
    }
}
