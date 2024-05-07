<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Core\User\Repository;

use WeProDev\LaraPanel\Core\User\Domain\RoleDomain;
use WeProDev\LaraPanel\Core\User\Dto\RoleDto;

interface RoleRepositoryInterface
{
    public function paginate(int $perPage);

    public function firstOrCreate(RoleDto $roleDto): RoleDomain;

    public function getDefaultRole(): RoleDomain;

    public function findBy(array $attributes): RoleDomain;
}
