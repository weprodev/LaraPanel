<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Infrastructure\User\Repository\Eloquent;

use App\Models\Role;
use WeProDev\LaraPanel\Core\User\Repository\RoleRepositoryInterface;
use WeProDev\LaraPanel\Infrastructure\Shared\Repository\BaseEloquentRepository;

class RoleEloquentRepository extends BaseEloquentRepository implements RoleRepositoryInterface
{
    protected $model = Role::class;

    // TODO use the existing methods

    public function syncRoleToUser($owner, array $roles = [])
    {
        return $owner->syncRoles($roles);
    }

    public function setRoleToMember($owner, $role, $assign = true)
    {
        if ($assign) {
            return $owner->assignRole($role);
        }

        return $owner->removeRole($role);
    }

    public function getAllRolePermissions(Role $role, $method = 'get')
    {
        if ($method == 'pluck') {
            return $role->getAllPermissions()->pluck('id', 'id')->toArray();
        }

        return $role->getAllPermissions();
    }
}
