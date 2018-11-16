<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;

class IndexActivity extends BaseRequest
{
    /**
     * Get list of order columns
     *
     * @return array
     */
    protected function listOrderColumns()
    {
        return ['created_at'];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'sort_by' => 'string|in:' . implode(",", $this->listOrderColumns()),
            'sort_dir' => 'string|in:asc,ASC,desc,DESC',
            'offset' => 'integer|min:0',
            'limit' => 'integer|min:1',
            'from_date' => 'sometimes|date',
            'to_date' => 'sometimes|date',
        ];
    }
}
