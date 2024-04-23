<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Core\User\Service;

use WeProDev\LaraPanel\Core\User\Domain\RoleDomain;

interface RoleServiceInterface
{
    public function getDefaultRole(): RoleDomain;
}
