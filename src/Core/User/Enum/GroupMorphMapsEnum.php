<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Core\User\Enum;

use WeProDev\LaraPanel\Infrastructure\User\Model\Group;
use WeProDev\LaraPanel\Infrastructure\User\Model\Role;
use WeProDev\LaraPanel\Infrastructure\User\Model\User;

enum GroupMorphMapsEnum: string
{
    case GROUP = Group::class;

    case USER = User::class;

    case ROLE = Role::class;
}
