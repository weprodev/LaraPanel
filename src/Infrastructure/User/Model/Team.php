<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Infrastructure\User\Model;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('larapanel.table.prefix').config('larapanel.table.team.name');
        $this->fillable = config('larapanel.table.team.columns');
    }
}
