<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Post extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
    ];
    public function postable():MorphTo
    {
        return $this->morphTo();
    }
}
