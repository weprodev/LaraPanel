<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Core\User\Enum;

enum UserStatusEnum: string
{
    case PENDING = 'PENDING';

    case ACCEPTED = 'ACCEPTED';

    case BLOCKED = 'BLOCKED';

    /**
     * @method static static[] cases()
     */
    public static function toArray(): array
    {
        return array_map(fn ($case) => $case->value, UserStatusEnum::cases());
    }
}
