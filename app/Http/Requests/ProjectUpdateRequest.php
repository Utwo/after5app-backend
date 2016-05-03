<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProjectUpdateRequest extends Request
{
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
            'title' => 'sometimes|required|string|min:4',
            'description' => 'sometimes|required|string|min:4',
            'positions' => 'sometimes|required',
            'positions.*.position_name' => 'required_with:positions|string',
            'positions.*.description' => 'required_with:positions|string',
            'application_questions' => 'sometimes|required',
            'application_questions.*' => 'required_with:application_questions|string',
            'status' => 'sometimes|required|boolean'
        ];
    }
}
