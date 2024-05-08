<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Infrastructure\User\Repository\Eloquent;

use Illuminate\Support\Collection;
use WeProDev\LaraPanel\Core\User\Domain\RoleDomain;
use WeProDev\LaraPanel\Core\User\Dto\RoleDto;
use WeProDev\LaraPanel\Core\User\Repository\RoleRepositoryInterface;
use WeProDev\LaraPanel\Infrastructure\User\Model\Role;
use WeProDev\LaraPanel\Infrastructure\User\Repository\Factory\RoleFactory;

class RoleEloquentRepository implements RoleRepositoryInterface
{
    public function paginate(int $perPage)
    {
        return Role::query()->paginate($perPage);
    }

    public function firstOrCreate(RoleDto $roleDto): RoleDomain
    {
        $roleModel = Role::firstOrCreate([
            'name' => $roleDto->getName(),
            'guard_name' => $roleDto->getGuardName()->value,
        ], [
            'name' => $roleDto->getName(),
            'title' => $roleDto->getTitle(),
            'guard_name' => $roleDto->getGuardName()->value,
            'description' => $roleDto->getDescription(),
        ]);

        return RoleFactory::fromEloquent($roleModel);
    }

    public function getDefaultRole(): RoleDomain
    {
        $roleDto = RoleDto::make(
            config('larapanel.auth.default.role', 'User'),
            config('larapanel.auth.default.role', 'Default User Role'),
        );

        return $this->firstOrCreate($roleDto);
    }

    public function findBy(array $attributes): RoleDomain
    {
        $roleModel = Role::where($attributes)->firstOrFail();

        return RoleFactory::fromEloquent($roleModel);
    }

    // public function setRoleToMember($owner, $role, $assign = true)
    // {
    //     if ($assign) {
    //         return $owner->assignRole($role);
    //     }

    //     return $owner->removeRole($role);
    // }

    public function getAllRolePermissions(array $attributes): Collection
    {
        $role = Role::where($attributes)->firstOrFail();

        return $role->getAllPermissions();
    }

    public function pluckAllRolePermissions(array $attributes): array
    {
        $role = Role::where($attributes)->firstOrFail();

        return $role->getAllPermissions()->pluck('id', 'id')->toArray();
    }
}
