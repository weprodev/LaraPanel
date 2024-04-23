<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Core\User\Domain;

use WeProDev\LaraPanel\Core\User\Enum\GuardTypeEnum;

final class RoleDomain
{
    public static function make(
        int $id,
        string $name,
        string $title,
        ?int $teamId = null,
        ?string $description = null,
        ?GuardTypeEnum $guardName = null
    ): RoleDomain {

        return new RoleDomain(
            $id,
            $name,
            $title,
            $teamId,
            $description,
            $guardName
        );
    }

    private function __construct(
        private readonly int $id,
        private readonly string $name,
        private readonly string $title,
        private readonly ?int $teamId = null,
        private readonly ?string $description = null,
        private ?GuardTypeEnum $guardName = null
    ) {
        $this->guardName = $guardName ?? GuardTypeEnum::WEB;
    }

    public function getId(): int
    {
        return $this->id;
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

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getGuardName(): GuardTypeEnum
    {
        return $this->guardName;
    }
}
