<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Infrastructure\User\Repository\Eloquent;

use WeProDev\LaraPanel\Core\User\Domain\PermissionDomain;
use WeProDev\LaraPanel\Core\User\Repository\PermissionRepositoryInterface;
use WeProDev\LaraPanel\Infrastructure\User\Model\Permission;
use WeProDev\LaraPanel\Infrastructure\User\Model\Role;
use WeProDev\LaraPanel\Infrastructure\User\Repository\Factory\PermissionFactory;

class PermissionEloquentRepository implements PermissionRepositoryInterface
{
    public function paginate(int $perPage)
    {
        return Permission::query()->paginate($perPage);
    }

    public function findBy(array $attributes): PermissionDomain
    {
        $permModel = Permission::where($attributes)->firstOrFail();

        return PermissionFactory::fromEloquent($permModel);
    }

    public function setPermissionToRole(int $roleId, $permission): void
    {
        $role = Role::find($roleId);

        return $role->givePermissionTo($permission);
    }

    public function revokePermFromRole(int $roleId, $permission): void
    {
        $role = Role::find($roleId);

        return $role->revokePermissionTo($permission);
    }

    public function SyncPermToRole(int $roleId, array $permissions): void
    {
        $role = Role::find($roleId);

        return $role->syncPermissions($permissions);
    }

    public function getPermissionsModule(): array
    {
        return array_keys(collect(Permission::get())->keyBy('module')->toArray());
    }
}
