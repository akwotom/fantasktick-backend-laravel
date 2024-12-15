<?php
/**
 * Copyright 2024 Son of Binary
 * The Fantasktick Project
 * This middleware does vaidation of user input
 */
namespace App\Http\Middleware;
use \Illuminate\Http\Request;

class Validation
{
    public function handle(Request $request, $next)
    {
        $isUpdate = str_starts_with($request->path(), 'update');

        $validator = Validator($request->jsonContent, array(
            'label' => 'string' . ($isUpdate ? '' : '|required'),
            'description' => 'string' . ($isUpdate ? '' : '|required'),
            'date' => 'string' . ($isUpdate ? '' : '|required'),
            'status' => 'string',
            'id' => 'string' . ($isUpdate ? '|required' : ''),
        ));

        if (!$validator->passes()) {
            return response()->json(
                array(
                    'success' => false,
                    'error' => $validator->errors()->first(),
                )
            )->setStatusCode(400, "Bad Request");
        }

        return $next($request);

    }
}
