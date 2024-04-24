<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Core\User\Repository;

use WeProDev\LaraPanel\Core\User\Domain\GroupDomain;
use WeProDev\LaraPanel\Core\User\Dto\GroupDto;
use WeProDev\LaraPanel\Core\User\Enum\GroupMorphMapsEnum;

interface GroupRepositoryInterface
{
    public function firstOrCreate(GroupDto $groupDto): GroupDomain;

    public function getDefaultGroup(): GroupDomain;

    public function assignGroup(GroupDomain $groupDomain, GroupMorphMapsEnum $modelType, int $modelId): void;
}
