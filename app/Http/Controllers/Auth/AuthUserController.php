<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Service\LoginServiceWithExceptions\Authenticated;
use App\Service\RegisterationServiceWithExceptions\Registrated;
use Illuminate\Http\JsonResponse;

class AuthUserController extends Controller
{
    //
    public function register(Registrated $registrated): JsonResponse
    {
        $returnResponse = $registrated->execute();

        return $returnResponse;
    }

    public function login(Authenticated $authenticated): JsonResponse
    {
        $user = $authenticated->execute();
        $token = $user->createToken('__AUTH_TOKEN__')->plainTextToken;
        return response()->json([
            'user'=>$user,
            'token'=>$token,
        ],200);
    }
}
