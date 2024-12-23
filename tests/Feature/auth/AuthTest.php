<?php

namespace Tests\Feature\auth;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use WithFaker;
    public function test_user_register_by_email():void
    {
        $email = $this->faker()->email;
        $password = $this->faker()->password;
        $name = $this->faker()->userName;
        $data = [
            'name'=>$name,
            'email'=>$email,
            'password'=>$password
        ];


        $response = $this->post('api/v1/user/register',$data);

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJson([
            'message'=>['successful registration']
        ]
        );
        $this->assertDatabaseHas('users',[
            'email'=>$email
        ]);
    }

    public function test_user_login_by_email():void
    {
        $email = $this->faker()->email;
        $password = $this->faker()->password;
        $user = User::factory()->create([
            'email'=>$email,
            'password'=>$password
        ]);


        $response = $this->postJson('api/v1/user/login',[
            'email'=>$email,
            'password'=>$password
        ]);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure(['user', 'token']);
        $response->assertJson([
            'user'=>$user->toArray()
        ]);
        $this->assertDatabaseHas('personal_access_tokens',[
            'name'=>'__Auth_TOKEN__',
            'tokenable_id'=>$user->id,
        ]);
    }

    public function test_login_admin_by_email():void
    {
        $email = $this->faker()->email;
        $password = $this->faker()->password;
        $admin = Admin::factory()->create([
            'email'=>$email,
            'password'=>$password
        ]);
        $response = $this->postJson('api/v1/admin/login',[
            'email'=>$email,
            'password'=>$password
        ]);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure(['admin','token']);
        $response->assertJson([
            'admin'=>$admin->toArray()
        ]);
        $this->assertDatabaseHas('personal_access_tokens',[
            'name'=>'__Auth_TOKEN__',
            'tokenable_id'=>$admin->id,
        ]);
    }

    public function test_invalid_email_or_password_in_user_login():void
    {
        $email = $this->faker()->email;
        $password = $this->faker()->password;
        $admin = User::factory()->create([
            'email'=>$email,
            'password'=>$password
        ]);
        $response = $this->postJson('api/v1/admin/login',[
            'email'=>$email,
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }


    public function test_invalid_email_or_password_in_admin_login():void
    {
        $email = $this->faker()->email;
        $password = $this->faker()->password;
        $admin = Admin::factory()->create([
            'email'=>$email,
            'password'=>$password
        ]);
        $response = $this->postJson('api/v1/admin/login',[
            'email'=>$email,
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
