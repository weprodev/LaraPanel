<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Infrastructure\User\Repository\Factory;

use Carbon\CarbonImmutable;
use Ramsey\Uuid\Uuid;
use WeProDev\LaraPanel\Core\Shared\Enum\LanguageEnum;
use WeProDev\LaraPanel\Core\User\Domain\UserDomain;
use WeProDev\LaraPanel\Core\User\Enum\UserStatusEnum;

final class UserFactory
{
    public static function fromEloquent($user): UserDomain
    {
        $userDomain = UserDomain::make(
            $user->id,
            Uuid::fromString($user->uuid),
            $user->email,
            $user->first_name,
            $user->last_name,
            UserStatusEnum::tryFrom($user->status),
            CarbonImmutable::parse($user->email_verified_at),
            $user->mobile,
            CarbonImmutable::parse($user->mobile_verified_at),
            LanguageEnum::tryFrom($user->language),
        );
        $userDomain->setRoles($user->roles);
        $userDomain->setPermissions($user->permissions);
        $userDomain->setGroups($user->groups);

        return $userDomain;
    }
}
