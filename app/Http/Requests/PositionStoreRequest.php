<?php

namespace App\Http\Requests;

use App\Project;
use Illuminate\Support\Facades\Gate;

class PositionStoreRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('user_own_project', Project::findOrFail($this->project_id));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|min:1|max:15',
            'description' => 'required|string|min:4',
            'status' => 'required|boolean',
            'project_id' => 'required|integer|exists:projects,id'
        ];
    }
}
