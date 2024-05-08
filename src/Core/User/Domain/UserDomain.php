<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Core\User\Domain;

use Carbon\CarbonImmutable;
use Ramsey\Uuid\UuidInterface;
use WeProDev\LaraPanel\Core\Shared\Enum\LanguageEnum;
use WeProDev\LaraPanel\Core\User\Enum\UserStatusEnum;

final class UserDomain
{
    public static function make(
        int $id,
        UuidInterface $uuid,
        string $email,
        string $firstName,
        string $lastName,
        UserStatusEnum $status,
        ?CarbonImmutable $emailVerifiedAt = null,
        ?string $mobile = null,
        ?CarbonImmutable $mobileVerifiedAt = null,
        ?LanguageEnum $language = null
    ): UserDomain {

        return new UserDomain(
            $id,
            $uuid,
            $email,
            $firstName,
            $lastName,
            $status,
            $emailVerifiedAt,
            $mobile,
            $mobileVerifiedAt,
            $language
        );
    }

    private function __construct(
        private readonly int $id,
        private readonly UuidInterface $uuid,
        private readonly string $email,
        private readonly string $firstName,
        private readonly string $lastName,
        private readonly UserStatusEnum $status,
        private readonly ?CarbonImmutable $emailVerifiedAt = null,
        private readonly ?string $mobile = null,
        private readonly ?CarbonImmutable $mobileVerifiedAt = null,
        private ?LanguageEnum $language = null,
    ) {
        $this->language = $language ?? LanguageEnum::default();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getStatus(): UserStatusEnum
    {
        return $this->status;
    }

    public function getEmailVerifiedAt(): ?CarbonImmutable
    {
        return $this->emailVerifiedAt;
    }

    public function getMobileVerifiedAt(): ?CarbonImmutable
    {
        return $this->mobileVerifiedAt;
    }

    public function getLanguage(): LanguageEnum
    {
        return $this->language;
    }
}
