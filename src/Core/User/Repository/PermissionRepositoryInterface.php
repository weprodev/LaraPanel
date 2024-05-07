<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Core\User\Repository;

use WeProDev\LaraPanel\Core\User\Domain\PermissionDomain;

interface PermissionRepositoryInterface
{
    public function paginate(int $perPage);

    public function findBy(array $attributes): PermissionDomain;

    public function setPermissionToRole(int $roleId, $permission): void;

    public function revokePermFromRole(int $roleId, $permission): void;

    public function SyncPermToRole(int $roleId, array $permissions): void;

    public function getPermissionsModule(): array;
}
