<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Core\User\Dto;

use WeProDev\LaraPanel\Core\Shared\Enum\LanguageEnum;
use WeProDev\LaraPanel\Core\User\Enum\UserStatusEnum;

final class UserDto
{
    public static function make(
        string $email,
        string $firstName,
        string $lastName,
        ?string $mobile = null,
        ?UserStatusEnum $status = null,
        ?LanguageEnum $language = null,
        ?string $password = null
    ): UserDto {

        return new UserDto(
            $email,
            $firstName,
            $lastName,
            $mobile,
            $status,
            $language,
            $password,
        );
    }

    private function __construct(
        private readonly string $email,
        private readonly string $firstName,
        private readonly string $lastName,
        private readonly ?string $mobile = null,
        private readonly ?UserStatusEnum $status = null,
        private ?LanguageEnum $language =  null,
        private readonly ?string $password = null
    ) {
        $this->language = $language ?? LanguageEnum::default();
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getMobile(): ?string
    {
        return $this->mobile;
    }

    public function getStatus(): ?UserStatusEnum
    {
        return $this->status;
    }

    public function getLanguage(): LanguageEnum
    {
        return $this->language;
    }
}
