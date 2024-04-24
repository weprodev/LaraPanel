<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Infrastructure\User\Model;

use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\Permission\Contracts\Role as RoleContract;
use Spatie\Permission\Exceptions\RoleDoesNotExist;
use Spatie\Permission\Guard;
use Spatie\Permission\Models\Role as SpatieRole;
use WeProDev\LaraPanel\Core\User\Enum\GroupMorphMapsEnum;

class Role extends SpatieRole
{
    private string $intermediateGroupTableName;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->intermediateGroupTableName = config('larapanel.table.prefix').config('larapanel.table.model_has_group.name');
    }

    public static function findByName(string $name, ?string $guardName = null): RoleContract
    {
        $guardName = $guardName ?? Guard::getDefaultName(static::class);

        $role = Role::where(['name' => $name, 'guard_name' => $guardName])->first();

        if (! $role) {
            throw RoleDoesNotExist::named($name, $guardName);
        }

        return $role;
    }

    public function groups(): MorphToMany
    {
        return $this->morphToMany(
            GroupMorphMapsEnum::ROLE->value,
            'groupable',
            $this->intermediateGroupTableName,
            'group_id',
            'groupable_id'
        );
    }
}
