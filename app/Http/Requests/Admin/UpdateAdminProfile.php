<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Rules\MatchPassword;

class UpdateAdminProfile extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $argumentName = $this->getLastPathElement();

        if ($argumentName == 'email'){
            return [
                'email' => [
                    'required',
                    'email',
                    Rule::unique('users')->ignore(Auth::id()),
                    Rule::unique('athletes'),
                    Rule::unique('contacts')
                ],
            ];
        }

        elseif ($argumentName == 'password'){
            return [
                'current_password' => [
                    'required',
                    new MatchPassword(),
                ],
                'password' => $this->baseRules['conf_password'],
            ];
        }

        else {
            return response('Bad Request', 400);
        }
    }
}
