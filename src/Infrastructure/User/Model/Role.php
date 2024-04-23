<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Infrastructure\User\Model;

use Spatie\Permission\Models\Role as SpatieRole;
use Spatie\Permission\Contracts\Role as RoleContract;
use Spatie\Permission\Exceptions\RoleDoesNotExist;
use Spatie\Permission\Guard;

class Role extends SpatieRole
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    public static function findByName(string $name, ?string $guardName = null): RoleContract
    {
        $guardName = $guardName ?? Guard::getDefaultName(static::class);

        $role = Role::where(['name' => $name, 'guard_name' => $guardName])->first();

        if (!$role) {
            throw RoleDoesNotExist::named($name, $guardName);
        }
        return $role;
    }
}
