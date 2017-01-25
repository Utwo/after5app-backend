<?php

namespace App\Http\Requests;

class UserUpdateRequest extends Request
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
            'name' => 'sometimes|present|nullable|string|min:3|max:20',
            'workplace' => 'sometimes|present|nullable|string|min:3',
            'twitter' => 'sometimes|present|nullable|string|min:3',
            'website' => 'sometimes|present|nullable|url',
            'hobbies' => 'sometimes|json_valid|array',
            'hobbies.*' => 'required_with:hobbies|string|min:1|max:15'
        ];
    }
}
