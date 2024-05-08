<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Core\User\Repository;

use Illuminate\Support\Collection;
use WeProDev\LaraPanel\Core\User\Domain\GroupDomain;
use WeProDev\LaraPanel\Core\User\Dto\GroupDto;
use WeProDev\LaraPanel\Core\User\Enum\GroupMorphMapsEnum;

interface GroupRepositoryInterface
{
    public function paginate(int $perPage);

    public function firstOrCreate(GroupDto $groupDto): GroupDomain;

    public function create(GroupDto $groupDto): GroupDomain;

    public function update(GroupDomain $groupDomain, GroupDto $groupDto): GroupDomain;

    public function getDefaultGroup(): GroupDomain;

    public function assignGroup(GroupDomain $groupDomain, GroupMorphMapsEnum $modelType, int $modelId): void;

    public function pluckAll(): Collection;

    public function findById(int $groupId): GroupDomain;

    public function delete(int $groupId): void;

    public function all(): Collection;
}
