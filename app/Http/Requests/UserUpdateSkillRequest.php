<?php

namespace App\Http\Requests;


class UserUpdateSkillRequest extends Request
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
            'skill' => 'required|array',
            'skill.*.name' => 'required_with:skill|string|min:1|max:15',
            'skill.*.skill_level' => 'required_with:skill|integer|min:1|max:100',
        ];
    }
}
