<?php

namespace App\Models; 

use App\Traits\HasDefaultPassword;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{

    use HasDefaultPassword;
    
    protected $table = 'users';
}