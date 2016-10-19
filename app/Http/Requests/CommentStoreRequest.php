<?php

namespace App\Http\Requests;

class CommentStoreRequest extends Request
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
            'text' => 'required|string|min:2',
            'project_id' => 'required|integer|exists:projects,id'
        ];
    }
}
