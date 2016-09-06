<?php

namespace App\Http\Requests;

use App\Position;
use App\Project;
use App\Skill;
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
        /*$skill = Skill::where(['name' => Skill::generate_name($this->position_name)])->first();
        $check_unique = false;

        if ($skill) {
            $check_unique = Position::where('project_id', $this->project_id)->where('skill_id', $skill->id)->exists();
        }*/

        return Gate::allows('user_own_project', Project::findOrFail($this->project_id));// && !$check_unique;
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
