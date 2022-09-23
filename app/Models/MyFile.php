<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Casts\SepratorCast;

class MyFile extends Model
{
    use HasFactory;

    protected $fillable = ['userId','path','tags'];

    protected $casts = [
        'tags' => SepratorCast::class
    ];
}
