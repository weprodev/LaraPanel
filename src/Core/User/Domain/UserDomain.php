<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Core\User\Domain;

final class UserDomain
{
    public static function make(): UserDomain
    {
        return new UserDomain;
    }

    private function __construct()
    {
    }
}
