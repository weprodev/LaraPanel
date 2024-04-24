<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Infrastructure\User\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use WeProDev\LaraPanel\Core\User\Enum\GroupMorphMapsEnum;

class Group extends Model
{
    private string $intermediateTableName;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('larapanel.table.prefix').config('larapanel.table.group.name');
        $this->fillable = config('larapanel.table.group.columns');

        $this->intermediateTableName = config('larapanel.table.prefix').config('larapanel.table.model_has_group.name');
    }

    public function users(): MorphToMany
    {
        return $this->morphedByMany(
            GroupMorphMapsEnum::USER->value,
            'groupable',
            $this->intermediateTableName,
            'group_id',
            'groupable_id'
        );
    }

    public function roles(): MorphToMany
    {
        return $this->morphedByMany(
            GroupMorphMapsEnum::ROLE->value,
            'groupable',
            $this->intermediateTableName,
            'group_id',
            'groupable_id'
        )->withTimestamps('created_at');
    }
}
