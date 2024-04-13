<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Infrastructure\User\Repository\Eloquent;

use App\Models\User;
use WeProDev\LaraPanel\Core\User\Repository\UserRepositoryInterface;
use WeProDev\LaraPanel\Infrastructure\Shared\Repository\BaseEloquentRepository;

class UserEloquentRepository extends BaseEloquentRepository implements UserRepositoryInterface
{
    protected $model = User::class;

    public function getUserBaseRole($roleRequest)
    {
        $query = $this->model::query();

        return $query
            ->when($roleRequest, function ($q) use ($roleRequest) {
                $q->whereHas('roles', function ($q) use ($roleRequest) {
                    $q->where('name', $roleRequest->name);
                });
            })
            ->orderBy('created_at', 'DESC')
            ->paginate();
    }

    public function allWithTrashed()
    {
        $query = $this->model::query();

        return $query->withTrashed()->orderBy('created_at', 'DESC')->paginate();
    }

    public function restoreUser(int $ID)
    {
        $query = $this->model::query();

        return $query->withTrashed()->where('id', $ID)->restore();
    }
}
