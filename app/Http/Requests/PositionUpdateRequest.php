<?php

namespace App\Http\Requests;

use App\Position;
use Illuminate\Support\Facades\Gate;

class PositionUpdateRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('user_own_project', Position::findOrFail(request()->route()->position)->Project);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'description' => 'sometimes|required|string|min:4',
            'status' => 'sometimes|required|boolean'
        ];
    }
}
