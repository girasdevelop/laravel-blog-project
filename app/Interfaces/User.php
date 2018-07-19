<?php
namespace App\Interfaces;

interface User
{
    /**
     * @return string
     */
    public function getNameAttribute(): string;

    /**
     * @param $value
     * @return void
     */
    public function setRolesAttribute($value): void;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles();
}