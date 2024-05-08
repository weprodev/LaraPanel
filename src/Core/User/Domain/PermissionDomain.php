<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Core\User\Domain;

use WeProDev\LaraPanel\Core\User\Enum\GuardTypeEnum;

final class PermissionDomain
{
    public static function make(
        int $id,
        string $name,
        string $title,
        string $module,
        ?string $description = null,
        ?GuardTypeEnum $guardName = null
    ): PermissionDomain {

        return new PermissionDomain(
            $id,
            $name,
            $title,
            $module,
            $description,
            $guardName
        );
    }

    private function __construct(
        private readonly int $id,
        private readonly string $name,
        private readonly string $title,
        private readonly string $module,
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
