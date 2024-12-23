<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index():jsonResponse
    {
        $posts = Post::all();
        return response()->json([
            'posts'=>$posts
        ],200);

    }

    public function store(PostRequest $request)
    {
        $user = null;
        if(Auth::check()){
            $user = Auth()->user();
        }else {
            $user = Auth::guard('admin')->user();
        }
        $createdPost = $user->posts()->create([
            'title'=>$request->title,
            'description'=> $request->description,
        ]);

        if(!$createdPost){
            return response()->json([
                'Message'=>'can\'t create a post'
            ],422);
        }

        return response()->json([
            'Message'=>'created Successfully'
        ],201);
    }

    public function show(string $id)
    {

    }

    public function update(PostRequest $request, string $id)
    {
        if(!Auth::check()){
            $user = Auth::user();
        }else {
            $user = Auth::guard('admin')->user();
        }

        $createdPost = $user->posts()->where('id',$id)->update([
            'title'=>$request->title,
            'description'=>$request->description,
        ]);

        if(!$createdPost){
            return response()->json([
                'Message'=>'can\'t updated a post'
            ],422);
        }

        return response()->json([
            'Message'=>'updated Successfully'
        ],200);
    }

    public function destroy(string $id)
    {
        if(!Auth::check()){
            $user = Auth::user();
        }else {
            $user = Auth::guard('admin')->user();
        }
        $createdPost = $user->posts()->where('id',$id)->delete();
        if(!$createdPost){
            return response()->json([
                'Message'=>'can\'t deleted a post'
            ],422);
        }

        return response()->json([
            'Message'=>'deleted Successfully'
        ],200);
    }
}
