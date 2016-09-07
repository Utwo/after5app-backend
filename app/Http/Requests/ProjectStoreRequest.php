<?php

namespace App\Http\Requests;

class ProjectStoreRequest extends Request
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
            'title' => 'required|string|min:4',
            'description' => 'required|string|min:4',
            'application_questions' => 'sometimes|json_valid|array',
            'application_questions.*' => 'required_with:application_questions|string|min:2|max:250',
            'status' => 'sometimes|required|boolean'
        ];
    }
}
