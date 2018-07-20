<?php
namespace App\Helpers;

use App\Exceptions\InvalidConfigException;
use App\Interfaces\User as UserInterface;

/**
 * Class Helper
 * @package App\Helpers
 */
class Helper
{
    /**
     * @param string $userModelClass
     * @throws InvalidConfigException
     */
    public static function checkUserInstance(string $userModelClass)
    {
        $interfaces = class_implements($userModelClass);

        if (!isset($interfaces[UserInterface::class])) {
            throw new InvalidConfigException('Class userModelClass must be instance of '.UserInterface::class.'.');
        }
    }
}
