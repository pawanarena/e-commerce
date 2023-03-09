<?php

namespace App\Models;

use Laratrust\Models\LaratrustRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends LaratrustRole
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'display_name',
        'description'
    ];
}
