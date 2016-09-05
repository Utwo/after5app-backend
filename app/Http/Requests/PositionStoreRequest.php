<?php

namespace App\Http\Requests;

use App\Project;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class PositionStoreRequest extends FormRequest
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
            'description' => 'required|string|min:4',
            'status' => 'sometimes|required|boolean',
            'project_id' => 'required|integer|exists:projects,id',
            'position_name' => 'required|string|min:1|max:15',
        ];
    }
}
