<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Core\User\Domain;

final class PermissionDomain
{
    public static function make(): PermissionDomain
    {
        return new PermissionDomain;
    }

    private function __construct()
    {
    }
}
