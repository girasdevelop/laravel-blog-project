<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Permission
 * @package App
 */
class Permission extends Model
{
    protected $fillable = [
        'name', 'slug', 'description',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permission', 'permission_id', 'role_id')->withTimestamps();
    }

    /**
     * @param $value
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtolower($value);
        $this->attributes['slug'] = str_slug(strtolower($value));
    }
}
