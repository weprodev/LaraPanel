<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Infrastructure\User\Repository\Eloquent;

use App\Models\Team;
use WeProDev\LaraPanel\Core\User\Repository\TeamRepositoryInterface;
use WeProDev\LaraPanel\Infrastructure\Shared\Repository\BaseEloquentRepository;

class TeamEloquentRepository extends BaseEloquentRepository implements TeamRepositoryInterface
{
    protected $model = Team::class;

    public function syncDepartments($owner, array $departments = [])
    {
        return $owner->departments()->sync($departments, true);
    }

    public function attachDepartment($owner, array $departments = [])
    {
        return $owner->departments()->attach($departments);
    }
}
