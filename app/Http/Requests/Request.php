<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest
{
    /**
     * Get the proper failed validation response for the request.
     *
     * @param  array  $errors
     * @return Response
     */
    public function response(array $errors)
    {
        return response()->json(['error' => $errors], 400);
    }

    /**
     * @return Response
     */
    public function forbiddenResponse()
    {
        return response()->json(['error' => 'Forbidden'], 403);
    }
}
