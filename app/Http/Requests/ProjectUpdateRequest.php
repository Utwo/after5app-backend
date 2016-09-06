<?php

namespace App\Http\Requests;

use App\Project;
use Illuminate\Support\Facades\Gate;

class ProjectUpdateRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('user_own_project', Project::findOrFail(request()->route()->project));
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
            'application_questions' => 'sometimes|required',
            'application_questions.*' => 'required_with:application_questions|string',
            'status' => 'sometimes|required|boolean'
        ];
    }
}
