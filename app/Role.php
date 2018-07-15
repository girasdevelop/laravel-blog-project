<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Role
 * @package App
 */
class Role extends Model
{
    protected $fillable = [
        'name', 'slug', 'description'
    ];

    protected $appends = ['permissions'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user', 'role_id', 'user_id')->withTimestamps();
    }

    /**
     * @param $value
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = str_slug(strtolower($value));
    }

    /**
     * @param $value
     */
    public function setPermissionsAttribute($value)
    {
        //$this->permissions->sync($value);
        $this->attributes['permissions'] = $value;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function getPermissionsAttribute()
    {
        return $this->belongsToMany(Permission::class, 'role_permission', 'role_id', 'permission_id')->withTimestamps();
    }

    /**
     * @param array $permissions
     * @return bool
     */
    public function hasAccess(array $permissions) : bool
    {
        foreach ($permissions as $permission) {
            if ($this->hasPermission($permission))
                return true;
        }
        return false;
    }

    /**
     * @param string $permission
     * @return bool
     */
    private function hasPermission(string $permission) : bool
    {
        //return $this->permissions[$permission] ?? false;
        return true;
    }
}
