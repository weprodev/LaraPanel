<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Infrastructure\User\Model;

use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }
}
