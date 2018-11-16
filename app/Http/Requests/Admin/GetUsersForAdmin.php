<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;

class GetUsersForAdmin extends BaseRequest
{
    /**
     * Get list of order columns
     *
     * @return array
     */
    protected function listOrderColumns()
    {
        return ['username', 'name', 'email', 'phone_number', 'country', 'created_at',];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'sort_by' => 'string|in:' . implode(",", $this->listOrderColumns()),
            'sort_dir' => 'string|in:asc,ASC,desc,DESC',
            'offset' => 'integer|min:0',
            'limit' => 'integer|min:1',
            'created_at' => 'sometimes|date',
            'name' => 'sometimes|string',
            'country' => 'sometimes|array',
            'status' => 'sometimes|numeric'
        ];
    }
}
