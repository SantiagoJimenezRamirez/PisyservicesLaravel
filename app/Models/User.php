<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $table = 'users';

    protected $fillable = [
        'name', 'username', 'password', 'email', 'identification', 'birthdate', 'role', 'address', 'termsAndConditions'
    ];

    protected $casts = [
        'birthdate' => 'datetime',
        'termsAndConditions' => 'boolean',
    ];

    public $timestamps = true;
}
