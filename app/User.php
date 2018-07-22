<?php
namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Itstructure\LaRbac\Contracts\User as RbacUserContract;
use Itstructure\LaRbac\Models\Administrable;

/**
 * Class User
 * @package App
 */
class User extends Authenticatable implements RbacUserContract
{
    use Notifiable, Administrable;

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
}
