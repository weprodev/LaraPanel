<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Infrastructure\User\Model;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use WeProDev\LaraPanel\Core\User\Enum\GroupMorphMapsEnum;
use WeProDev\LaraPanel\Core\User\Enum\GuardTypeEnum;
use WeProDev\LaraPanel\Infrastructure\User\Traits\HasGroups;

class User extends Authenticatable
{
    use HasGroups, HasRoles, Notifiable;

    private string $intermediateGroupTableName;

    protected $guard_name = GuardTypeEnum::WEB->value;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = config('larapanel.table.prefix').config('larapanel.table.user.name');
        $this->fillable = config('larapanel.table.user.columns');
        $this->intermediateGroupTableName = config('larapanel.table.prefix').config('larapanel.table.model_has_group.name');
    }

    protected function password(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => bcrypt($value)
        );
    }

    public function groups(): MorphToMany
    {
        return $this->morphToMany(
            GroupMorphMapsEnum::GROUP->value,
            'groupable',
            $this->intermediateGroupTableName,
            'groupable_id',
            'group_id'
        );
    }
}
