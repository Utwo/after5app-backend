<?php

namespace App\Http\Requests;

use App\Application;
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
        $project_application_count = Application::where('user_id', auth()->user()->id)->where('project_id', $this->project_id)->count();
        if ($project_application_count == 0) {
            return true;
        }
        return false;
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
