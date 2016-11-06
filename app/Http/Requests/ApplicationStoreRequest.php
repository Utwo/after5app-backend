<?php

namespace App\Http\Requests;

use App\Application;
use App\Position;

class ApplicationStoreRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $position = Position::findOrFail($this->position_id);
        $project = $position->Project;
        $position_application_count = Application::where('user_id', auth()->user()->id)->where('position_id', $this->position_id)->count();
        if ($position_application_count == 0 && $project->user_id != auth()->user()->id && $position->status == 1) {
            //daca nu este proiectul meu si daca nu mai am aplicatii la aceasta pozitie si daca statusul positiei este 1
            return true;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'message' => 'sometimes|required|string',
            'answers' => 'sometimes|json_valid|array',
            'answers.*' => 'required_with:answers|string|min:1|max:500',
            'position_id' => 'required|integer|exists:positions,id'
        ];
    }
}
