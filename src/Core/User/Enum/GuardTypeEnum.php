<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Core\User\Enum;

enum GuardTypeEnum: string
{
    case WEB = 'WEB';

    case API = 'API';

    public static function getGuardType(string|GuardTypeEnum $guard): GuardTypeEnum
    {
        if ($guard instanceof GuardTypeEnum) {
            return $guard;
        }

        $guardNames = self::all();

        if (!empty($guardNames) && in_array($guard, $guardNames) && !self::isValueValid($guard)) {
            self::createNewCase($guard);
            return self::from($guard);
        }

        if (self::isValueValid($guard)) {
            return self::from($guard);
        }

        throw new \Exception('The guard name is not valid!');
    }

    private static function isValueValid(string $value): bool
    {
        return !is_null(self::tryFrom($value));
    }

    private static function createNewCase(string $guard): void
    {
        // Check if the guard already exists as a case
        if (!self::isValueValid($guard)) {
            // Dynamically add a new case to the enum
            eval("enum GuardTypeEnum: string { case $guard = '$guard'; }");
        }
    }

    public static function all(): array
    {
        $guardNames = config('larapanel.permission.guard.names') ?? [];

        return array_merge($guardNames, [
            self::WEB->value => self::WEB->value,
            self::API->value => self::API->value,
        ]);
    }

    public static function default(): GuardTypeEnum
    {
        $guard = config('larapanel.permission.guard.default', self::WEB->value);

        return self::from($guard);
    }
}
