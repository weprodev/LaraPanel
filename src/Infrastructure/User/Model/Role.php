<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Infrastructure\User\Model;

use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = $this->table;
    }
}
