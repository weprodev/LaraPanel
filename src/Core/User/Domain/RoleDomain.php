<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Core\User\Domain;

final class RoleDomain
{
    public static function make(): RoleDomain
    {
        return new RoleDomain;
    }

    private function __construct()
    {
    }
}
