<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Role extends Model
{
    /**
     * The users that belong to the Role
     *
     */
    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('permissions');
    }
}
