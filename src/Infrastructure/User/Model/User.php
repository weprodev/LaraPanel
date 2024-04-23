<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Infrastructure\User\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use WeProDev\LaraPanel\Core\User\Enum\GuardTypeEnum;

class User extends Authenticatable
{
    use HasRoles, Notifiable;

    protected $guard_name = GuardTypeEnum::WEB->value;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = config('larapanel.table.prefix') . config('larapanel.table.user.name');
        $this->fillable = config('larapanel.table.user.columns');
    }

    public function setPasswordAttribute($password): void
    {
        $this->attributes['password'] = bcrypt($password);
    }
}
