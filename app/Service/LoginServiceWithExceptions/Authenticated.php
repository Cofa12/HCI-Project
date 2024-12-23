<?php

namespace App\Service\LoginServiceWithExceptions;

use App\Http\Requests\LoginRequest;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

final readonly class Authenticated
{
    public function __construct(private LoginRequest $request){}

    public function execute(string $role = 'user'):Model
    {
        if(!auth()->guard($role)->attempt([
            'email'=>$this->request->email,
            'password'=>$this->request->password
        ])){
            throw new InvalidLoginAttemptException();
        }
        return $this->request->user($role);
    }

}
