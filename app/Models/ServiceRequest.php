<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    use HasFactory;

    protected $table = 'service';

    protected $fillable = [
        'name', 'email', 'message'
    ];

    public $timestamps = true;
}
