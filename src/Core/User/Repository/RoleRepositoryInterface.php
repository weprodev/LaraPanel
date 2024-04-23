<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Core\User\Repository;

use WeProDev\LaraPanel\Core\User\Domain\RoleDomain;
use WeProDev\LaraPanel\Core\User\Dto\RoleDto;

interface RoleRepositoryInterface
{
    public function firstOrCreate(RoleDto $roleDto): RoleDomain;
}
