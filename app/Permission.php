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
}
