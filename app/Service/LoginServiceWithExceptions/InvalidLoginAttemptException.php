<?php

namespace App\Service\LoginServiceWithExceptions;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use RuntimeException;

class InvalidLoginAttemptException extends RuntimeException
{
    public function render(): JsonResponse
    {
        return response()->json([
            'error'=>['invalid credentials'],
        ],Response::HTTP_BAD_REQUEST);
    }
}
