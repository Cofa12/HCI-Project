<?php

namespace App\Service\RegisterationServiceWithExceptions;

use Illuminate\Http\JsonResponse;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response;

class InvalidInsertionInDatabaseException extends RuntimeException
{
    public function render():JsonResponse
    {
        return response()->json([
            'error'=>['can\'t insert the data']
        ],Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
