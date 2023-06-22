<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shark extends Model
{
    protected $fillable = ['name', 'email', 'shark_level'];
    use HasFactory;
}
