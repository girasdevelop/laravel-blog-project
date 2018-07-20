<?php
namespace App\Interfaces;

/**
 * Interface User
 * @package App\Interfaces
 */
interface User
{
    /**
     * @return int
     */
    public function getIdAttribute(): int;

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