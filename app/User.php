<?php
namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Itstructure\LaRbac\Contracts\User as RbacUserContract;
use Itstructure\LaRbac\Models\Role;

/**
 * Class User
 * @package App
 */
class User extends Authenticatable implements RbacUserContract
{
    use Notifiable;

    /**
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'roles'
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @var array
     */
    private $_roles;

    /**
     * @return int
     */
    public function getIdAttribute(): int
    {
        return $this->attributes['id'];
    }

    /**
     * @return string
     */
    public function getNameAttribute(): string
    {
        return $this->attributes['name'];
    }

    /**
     * @param $value
     * @return void
     */
    public function setRolesAttribute($value): void
    {
        $this->_roles = $value;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_role', 'user_id', 'role_id')->withTimestamps();
    }

    /**
     * Checks if User has access to $permissions.
     * @param array $permissions
     * @return bool
     */
    public function hasAccess(array $permissions) : bool
    {
        // check if the permission is available in any role
        /* @var Role $role */
        foreach ($this->roles as $role) {
            if($role->hasAccess($permissions)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Checks if the user belongs to role.
     * @param string $roleSlug
     * @return bool
     */
    public function inRole(string $roleSlug): bool
    {
        return $this->roles()->where('slug', $roleSlug)->count() == 1;
    }

    /**
     * @param array $options
     * @return bool
     */
    public function save(array $options = [])
    {
        $saved = parent::save($options);

        if ($saved) {
            $this->roles()->sync($this->_roles);
            return true;
        }

        return false;
    }
}
