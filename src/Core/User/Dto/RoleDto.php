<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Core\User\Dto;

use WeProDev\LaraPanel\Core\User\Enum\GuardTypeEnum;

final class RoleDto
{
    public static function make(
        string $name,
        string $title,
        ?string $description = null,
        ?GuardTypeEnum $guardName = null
    ): RoleDto {

        return new RoleDto(
            $name,
            $title,
            $description,
            $guardName
        );
    }

    private function __construct(
        private readonly string $name,
        private readonly string $title,
        private readonly ?string $description = null,
        private ?GuardTypeEnum $guardName = null
    ) {
        $this->guardName = $guardName ?? GuardTypeEnum::WEB;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTitle(): string
    {
        return $this->title;
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
