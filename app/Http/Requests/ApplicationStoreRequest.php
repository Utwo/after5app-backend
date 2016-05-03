<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ApplicationStoreRequest extends Request
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
            'message' => 'required|string',
            'answers' => 'sometimes|required',
            'answers.*.question' => 'required_with:answers|string',
            'answers.*.text' => 'required_with:answers|string',
            'project_id' => 'required|integer|exists:projects,id'
        ];
    }
}
