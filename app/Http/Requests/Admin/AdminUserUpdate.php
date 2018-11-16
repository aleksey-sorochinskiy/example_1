<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\User\UserUpdate;
use App\User;

/**
 * Class AdminUserUpdate
 * @package App\Http\Requests\Admin
 */
class AdminUserUpdate extends UserUpdate
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules($userId = null)
    {
        $userId = $this->getLastPathElement();;

        $rules = parent::rules($userId);
        $rules['status'] = 'numeric|in:0,1';

        return $rules;
    }
}
