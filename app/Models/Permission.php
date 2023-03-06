<?php

namespace App\Models;

use Laratrust\Models\LaratrustPermission;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permission extends LaratrustPermission
{
    use HasFactory;
    public $guarded = [];
}
