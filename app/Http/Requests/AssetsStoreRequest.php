<?php

namespace App\Http\Requests;

use App\Project;
use Illuminate\Support\Facades\Gate;

class AssetsStoreRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('user_contribute_to_project', Project::findOrFail($this->project_id));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'assets' => 'required|file|max:80000|mimes:jpeg,png,txt,json',
            'project_id' => 'required|integer|exists:projects,id',
        ];
    }
}
