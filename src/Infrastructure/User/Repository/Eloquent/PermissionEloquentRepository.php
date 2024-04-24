<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Infrastructure\User\Repository\Eloquent;

use WeProDev\LaraPanel\Core\User\Repository\PermissionRepositoryInterface;

class PermissionEloquentRepository implements PermissionRepositoryInterface
{
    // public function setPermissionToRole(int $roleID, $permission, $give = true)
    // {
    //     $query = $this->roleModel::query();
    //     $role = $query->find($roleID);

    //     if ($give) {
    //         return $role->givePermissionTo($permission);
    //     }

    //     return $role->revokePermissionTo($permission);
    // }

    // public function SyncPermToRole(int $roleID, array $permissions)
    // {
    //     $query = $this->roleModel::query();
    //     $role = $query->find($roleID);

    //     return $role->syncPermissions($permissions);
    // }

    // public function getPermissionsModule()
    // {
    //     $query = $this->model::query();

    //     return array_keys(collect($query->get())->keyBy('module')->toArray());
    // }
}
