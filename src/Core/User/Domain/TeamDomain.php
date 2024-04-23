<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Core\User\Domain;

final class TeamDomain
{
    public static function make(
        int $id,
        string $name,
        string $title,
        ?int $parentId = null,
        ?string $description = null,
    ): TeamDomain {

        return new TeamDomain(
            $id,
            $name,
            $title,
            $parentId,
            $description
        );
    }

    private function __construct(
        private readonly int $id,
        private readonly string $name,
        private readonly string $title,
        private readonly ?int $parentId = null,
        private readonly ?string $description = null
    ) {
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

    public function getParent(): ?int
    {
        return $this->parentId;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }
}
