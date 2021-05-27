<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Idea extends Model
{
    use HasApiTokens, HasFactory;
}
