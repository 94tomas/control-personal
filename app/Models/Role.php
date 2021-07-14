<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Role extends Model
{
    /**
     * The users that belong to the Role
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
