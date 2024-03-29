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
            'description' => 'sometimes|present|nullable|string|min:2|max:400',
            'city' => 'sometimes|present|nullable|string|min:2|max:255',
            'notify_email' => 'sometimes|required|boolean',
            'workplace' => 'sometimes|present|nullable|string|min:3|max:255',
            'twitter' => 'sometimes|present|nullable|string|min:3|max:255',
            'website' => 'sometimes|present|nullable|url',
            'hobbies' => 'sometimes|json_valid|array',
            'hobbies.*' => 'required_with:hobbies|string|min:1|max:15',
            'social' => 'sometimes|json_valid|array|max:3',
            'social.*' => 'sometimes|string|min:1|max:15'
        ];
    }
}
