<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    use HasFactory, HasApiTokens;
    //
    protected $fillable = [
      'name',
      'email',
      'password'
    ];

    public function posts():MorphMany
    {
        return $this->morphMany(Post::class,'postable');
    }
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
}
