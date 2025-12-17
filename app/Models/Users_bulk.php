<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Users_bulk extends Model
{
    protected $table = 'users_bulks';
    protected $fillable = [
        'name',
        'email'
    ];
}
