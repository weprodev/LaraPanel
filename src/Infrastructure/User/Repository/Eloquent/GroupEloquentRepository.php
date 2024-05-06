<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Infrastructure\User\Repository\Eloquent;

use Exception;
use WeProDev\LaraPanel\Core\User\Domain\GroupDomain;
use WeProDev\LaraPanel\Core\User\Dto\GroupDto;
use WeProDev\LaraPanel\Core\User\Enum\GroupMorphMapsEnum;
use WeProDev\LaraPanel\Core\User\Repository\GroupRepositoryInterface;
use WeProDev\LaraPanel\Infrastructure\User\Model\Group;
use WeProDev\LaraPanel\Infrastructure\User\Repository\Factory\GroupFactory;

class GroupEloquentRepository implements GroupRepositoryInterface
{
    public function firstOrCreate(GroupDto $groupDto): GroupDomain
    {
        $groupModel = Group::firstOrCreate([
            'name' => $groupDto->getName(),
        ], [
            'name' => $groupDto->getName(),
            'title' => $groupDto->getTitle(),
            'parent_id' => $groupDto->getParentId(),
            'description' => $groupDto->getDescription(),
        ]);

        return GroupFactory::fromEloquent($groupModel);
    }

    public function getDefaultGroup(): GroupDomain
    {
        $groupDto = GroupDto::make(
            config('larapanel.auth.default.group', 'Default'),
            config('larapanel.auth.default.group', 'Default Group')
        );

        return $this->firstOrCreate($groupDto);
    }

    public function assignGroup(
        GroupDomain $groupDomain,
        GroupMorphMapsEnum $modelType,
        int $modelId
    ): void {
        $groupModel = Group::where('id', $groupDomain->getId())->firstOrFail();

        match ($modelType) {
            GroupMorphMapsEnum::USER => $groupModel->users()->attach($modelId),
            GroupMorphMapsEnum::ROLE => $groupModel->roles()->attach($modelId),
            default => throw new Exception('model type does not exist!'),
        };
    }
}