<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Infrastructure\User\Repository\Eloquent;

use WeProDev\LaraPanel\Core\User\Domain\RoleDomain;
use WeProDev\LaraPanel\Core\User\Dto\RoleDto;
use WeProDev\LaraPanel\Core\User\Repository\RoleRepositoryInterface;
use WeProDev\LaraPanel\Infrastructure\User\Model\Role;
use WeProDev\LaraPanel\Infrastructure\User\Repository\Factory\RoleFactory;

class RoleEloquentRepository implements RoleRepositoryInterface
{
    public function firstOrCreate(RoleDto $roleDto): RoleDomain
    {
        $roleModel = Role::firstOrCreate([
            'name' => $roleDto->getName(),
            'guard_name' => $roleDto->getGuardName()->value,
        ], [
            'name' => $roleDto->getName(),
            'title' => $roleDto->getTitle(),
            'guard_name' => $roleDto->getGuardName()->value,
            'team_id' => $roleDto->getTeamId(),
            'description' => $roleDto->getDescription(),
        ]);

        return RoleFactory::fromEloquent($roleModel);
    }

    // public function syncRoleToUser($owner, array $roles = [])
    // {
    //     return $owner->syncRoles($roles);
    // }

    // public function setRoleToMember($owner, $role, $assign = true)
    // {
    //     if ($assign) {
    //         return $owner->assignRole($role);
    //     }

    //     return $owner->removeRole($role);
    // }

    // public function getAllRolePermissions(Role $role, $method = 'get')
    // {
    //     if ($method == 'pluck') {
    //         return $role->getAllPermissions()->pluck('id', 'id')->toArray();
    //     }

    //     return $role->getAllPermissions();
    // }
}
