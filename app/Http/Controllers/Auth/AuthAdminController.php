<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Service\LoginServiceWithExceptions\Authenticated;
use Illuminate\Http\JsonResponse;

class AuthAdminController extends Controller
{
    public function login(Authenticated $authenticated):JsonResponse
    {
        $admin = $authenticated->execute('admin');
        $token = $admin->createToken('__AUTH_TOKEN__')->plainTextToken;
        return response()->json([
            'admin'=>$admin,
            'token'=>$token
        ],200);
    }
}
