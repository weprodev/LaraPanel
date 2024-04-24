<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Infrastructure\User\Repository\Factory;

use WeProDev\LaraPanel\Core\User\Domain\GroupDomain;
use WeProDev\LaraPanel\Infrastructure\User\Model\Group;

final class GroupFactory
{
    public static function fromEloquent(Group $group): GroupDomain
    {
        return GroupDomain::make(
            $group->id,
            $group->name,
            $group->title,
            $group->parent_id,
            $group->description,
        );
    }
}
