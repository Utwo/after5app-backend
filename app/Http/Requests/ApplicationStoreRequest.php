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
        $project = Position::findOrFail($this->position_id)->Project;
        $position_application_count = Application::where('user_id', auth()->user()->id)->where('position_id', $this->position_id)->count();
        if ($position_application_count == 0 && $project->user_id != auth()->user()->id) {
            //daca nu este proiectul meu si daca nu mai am aplicatii la aceasta pozitie
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
            'message' => 'required|string',
            'answers' => 'sometimes|required',
            'answers.*' => 'required_with:answers|string',
            'position_id' => 'required|integer|exists:positions,id'
        ];
    }
}
