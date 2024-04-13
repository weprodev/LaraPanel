<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Core\User\Repository;

use WeProDev\LaraPanel\Core\Shared\Repository\BaseRepositoryInterface;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    public function allWithTrashed();

    public function restoreUser(int $ID);
}
