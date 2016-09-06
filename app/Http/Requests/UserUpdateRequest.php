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
            'workplace' => 'sometimes|required|string|min:3',
            'twitter' => 'sometimes|required|string|min:3',
            'website' => 'sometimes|required|url',
        ];
    }
}
