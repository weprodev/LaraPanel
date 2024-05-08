<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Infrastructure\User\Repository\Factory;

use WeProDev\LaraPanel\Core\User\Domain\PermissionDomain;
use WeProDev\LaraPanel\Core\User\Enum\GuardTypeEnum;
use WeProDev\LaraPanel\Infrastructure\User\Model\Permission;

final class PermissionFactory
{
    public static function fromEloquent(Permission $perm): PermissionDomain
    {
        return PermissionDomain::make(
            $perm->id,
            $perm->name,
            $perm->title,
            $perm->module,
            $perm->description,
            GuardTypeEnum::getGuardType($perm->guard_name)
        );
    }
}
