<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Core\User\Dto;

use WeProDev\LaraPanel\Core\User\Enum\GuardTypeEnum;

final class PermissionDto
{
    public static function make(
        string $name,
        string $title,
        string $module,
        ?string $description = null,
        ?GuardTypeEnum $guardName = GuardTypeEnum::WEB
    ): PermissionDto {

        return new PermissionDto(
            $name,
            $title,
            $module,
            $description,
            $guardName
        );
    }

    private function __construct(
        private readonly string $name,
        private readonly string $title,
        private readonly string $module,
        private readonly ?string $description = null,
        private readonly ?GuardTypeEnum $guardName = GuardTypeEnum::WEB
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getModule(): string
    {
        return $this->module;
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
