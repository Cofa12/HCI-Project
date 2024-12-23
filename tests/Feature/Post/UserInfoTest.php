<?php

namespace Post;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class UserInfoTest extends TestCase
{
    use WithFaker;
    public function test_admin_can_create_user():void
    {
        $name = $this->faker()->userName;
        $email = $this->faker()->email;
        $password = $this->faker()->password;
        Admin::factory()->create([
            'name'=>$name,
            'email'=>$email,
            'password'=>$password
        ]);

        Auth::guard('admin')->attempt(['email'=>$email,'password'=>$password]);

        $userData = [
            'name'=>$this->faker()->userName,
            'email'=>$this->faker()->email,
            'password'=>$this->faker()->password
        ];


        $response = $this->post('api/v1/admin/user',$userData);


        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJsonStructure(['message']);
        $response->assertJson([
            'message'=>'User has been created successfully',
            'user'=>array_slice($userData,0,2)
        ]);
        $this->assertDatabaseHas('users',['email'=>$userData['email']]);
    }


    public function test_unautherized_admin_can_not_create_user():void
    {

        $name = $this->faker()->userName;
        $email = $this->faker()->email;
        $password = $this->faker()->password;
        $user = User::factory()->create([
            'name'=>$name,
            'email'=>$email,
            'password'=>$password
        ]);

        $userData = [
            'name'=>$this->faker()->userName,
            'email'=>$this->faker()->email,
            'password'=>$this->faker()->password
        ];

        Auth::attempt(['email'=>$email,'password'=>$password]);


        $response = $this->post('api/v1/admin/user',$userData);


        $response->assertStatus(Response::HTTP_UNAUTHORIZED);

    }

    public function test_get_all_users():void
    {
        Auth::guard('admin')->attempt(['email'=>'cofa@gmail.com','password'=>'cofa20##20##']);

        $response = $this->get('api/v1/admin/user');
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'users'=>[
                ['email'],
                ['name']
            ]
        ]);
    }
}
