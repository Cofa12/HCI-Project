<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddingUserRequest;
use App\Http\Requests\DeleteUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class AdminActingController extends Controller
{
    //
    public function addUser(AddingUserRequest $request): JsonResponse
    {

        $user = User::factory()->create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>$request->password,
        ]);


        return response()->json([
            'message'=>'User has been created successfully',
            'user'=>$user
        ],201);
    }

    public function getUsers():JsonResponse
    {
        $users = User::all('email','name');
        return response()->json([
            'users'=>$users
        ],200);
    }

    public function updateUser(UpdateUserRequest $request):JsonResponse
    {
        $updatedUser = User::where('email',$request->email)->update([
            'name'=>'name'
        ]);

        if(!$updatedUser){
            return response()->json([
                'Message'=>'can\'t update the row'
            ],422);
        }

        return response()->json([
            'Message'=>'Updated Successfully'
        ],200);
    }

    public function totalUser():JsonResponse
    {
        $totalUsers = User::all()->count();

        return response()->json([
            'n_users'=>$totalUsers
        ],200);
    }

    public function deleteUser(DeleteUserRequest $request):JsonResponse
    {
        $deletedUserStatus = User::where('email',$request->email)->delete();

        if(!$deletedUserStatus){
            return response()->json([
                'Message'=>'can\'t delete the row'
            ],422);
        }

        return response()->json([
            'Message'=>'Deleted Successfully'
        ],200);
    }

}
