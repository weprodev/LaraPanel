<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Core\User\Dto;

final class GroupDto
{
    public static function make(
        string $name,
        string $title,
        ?int $parentId = null,
        ?string $description = null,
    ): GroupDto {

        return new GroupDto(
            $name,
            $title,
            $parentId,
            $description
        );
    }

    private function __construct(
        private readonly string $name,
        private readonly string $title,
        private readonly ?int $parentId = null,
        private readonly ?string $description = null
    ) {}

    public function getName(): string
    {
        return $this->name;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getParentId(): ?int
    {
        return $this->parentId;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }
}
