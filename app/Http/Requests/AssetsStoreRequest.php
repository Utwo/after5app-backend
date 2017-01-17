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
        $project = Project::withCount('Asset')->findOrFail($this->project_id);
        if ($project->asset_count > config('app.max_assets_number', 6)) {
            return false;
        }
        return Gate::allows('user_contribute_to_project', $project);
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
