<?php

namespace App\Service\RegisterationServiceWithExceptions;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final readonly class Registrated
{
    public function __construct(private RegisterRequest $request){}

    public function execute():JsonResponse
    {
        $insertedData = User::create([
            'name'=>$this->request->name,
            'email'=>$this->request->email,
            'password'=>$this->request->password
        ]);

        if(!$insertedData){
            throw new InvalidInsertionInDatabaseException();
        }

        return response()->json([
                'message'=>['successful registration']
        ],Response::HTTP_CREATED);
    }

}
