<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Infrastructure\User\Repository\Factory;

use WeProDev\LaraPanel\Core\User\Domain\RoleDomain;
use WeProDev\LaraPanel\Core\User\Enum\GuardTypeEnum;
use WeProDev\LaraPanel\Infrastructure\User\Model\Role;

final class RoleFactory
{
    public static function fromEloquent(Role $role): RoleDomain
    {
        return RoleDomain::make(
            $role->id,
            $role->name,
            $role->title,
            $role->team_id,
            $role->description,
            GuardTypeEnum::tryFrom($role->guard_name)
        );
    }
}
