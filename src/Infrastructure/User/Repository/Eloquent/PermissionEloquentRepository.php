<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Infrastructure\User\Repository\Eloquent;

use App\Models\Permission;
use App\Models\Role;
use WeProDev\LaraPanel\Core\User\Repository\PermissionRepositoryInterface;
use WeProDev\LaraPanel\Infrastructure\Shared\Repository\BaseEloquentRepository;

class PermissionEloquentRepository extends BaseEloquentRepository implements PermissionRepositoryInterface
{
    protected $model = Permission::class;

    protected $roleModel = Role::class;

    // TODO use the existing methods

    public function setPermissionToRole(int $roleID, $permission, $give = true)
    {
        $query = $this->roleModel::query();
        $role = $query->find($roleID);

        if ($give) {
            return $role->givePermissionTo($permission);
        }

        return $role->revokePermissionTo($permission);
    }

    public function SyncPermToRole(int $roleID, array $permissions)
    {
        $query = $this->roleModel::query();
        $role = $query->find($roleID);

        return $role->syncPermissions($permissions);
    }

    public function getPermissionsModule()
    {
        $query = $this->model::query();

        return array_keys(collect($query->get())->keyBy('module')->toArray());
    }
}