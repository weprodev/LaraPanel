<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Core\User\Repository;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use WeProDev\LaraPanel\Core\User\Domain\RoleDomain;
use WeProDev\LaraPanel\Core\User\Dto\RoleDto;

interface RoleRepositoryInterface
{
    public function paginate(int $perPage);

    public function firstOrCreate(RoleDto $roleDto): RoleDomain;

    public function create(RoleDto $roleDto): RoleDomain;

    public function update(RoleDomain $roleDomain, RoleDto $roleDto): RoleDomain;

    public function getDefaultRole(): RoleDomain;

    public function findBy(array $attributes): RoleDomain;

    public function delete(int $roleId): void;

    public function all(): EloquentCollection;
}
