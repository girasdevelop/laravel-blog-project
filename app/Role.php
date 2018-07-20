<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Exceptions\InvalidConfigException;
use App\Helpers\Helper;

/**
 * Class Role
 * @package App
 */
class Role extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'description', 'permissions'
    ];

    /**
     * @var string
     */
    private $userModelClass;

    /**
     * @var array
     */
    private $permissions;

    /**
     * Role constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->userModelClass = config('rbac.userModelClass');

        parent::__construct($attributes);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     * @throws InvalidConfigException
     */
    public function users()
    {
        Helper::checkUserInstance($this->userModelClass);

        return $this->belongsToMany($this->userModelClass, 'role_user', 'role_id', 'user_id')->withTimestamps();
    }

    /**
     * @param $value
     * @return void
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = str_slug(strtolower($value));
    }

    /**
     * @param $value
     * @return void
     */
    public function setPermissionsAttribute($value)
    {
        $this->permissions = $value;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
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
        return in_array($permission, $this->permissions()->pluck('slug')->toArray());
    }

    /**
     * @param array $options
     * @return bool
     */
    public function save(array $options = [])
    {
        $saved = parent::save($options);

        if ($saved) {
            $this->permissions()->sync($this->permissions);
            return true;
        }

        return false;
    }
}
