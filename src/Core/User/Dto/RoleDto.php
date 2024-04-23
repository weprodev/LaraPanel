<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Core\User\Dto;

use WeProDev\LaraPanel\Core\User\Enum\GuardTypeEnum;
use WeProDev\LaraPanel\Core\User\Repository\TeamRepositoryInterface;

final class RoleDto
{
    public static function make(
        string $name,
        string $title,
        ?int $teamId = null,
        ?string $description = null,
        GuardTypeEnum $guardName = GuardTypeEnum::WEB,
    ): RoleDto {

        return new RoleDto(
            $name,
            $title,
            $teamId,
            $description,
            $guardName
        );
    }

    private TeamRepositoryInterface $teamRepository;
    private function __construct(
        private readonly string $name,
        private readonly string $title,
        private ?int $teamId = null,
        private readonly ?string $description = null,
        private readonly GuardTypeEnum $guardName = GuardTypeEnum::WEB,
    ) {
        $this->teamRepository = resolve(TeamRepositoryInterface::class);
        $this->teamId = $teamId ?? $this->teamRepository->getDefaultTeam()->getId();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getTeamId(): int
    {
        return $this->teamId;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getGuardName(): GuardTypeEnum
    {
        return $this->guardName;
    }
}
