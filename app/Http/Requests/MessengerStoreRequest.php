<?php

namespace App\Http\Requests;

use App\Project;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class MessengerStoreRequest extends FormRequest
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
            'text' => 'required|string|min:1|max:250',
            'project_id' => 'required|integer|exists:projects,id',
        ];
    }
}
