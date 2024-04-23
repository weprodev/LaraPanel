<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Infrastructure\User\Repository\Eloquent;

use Illuminate\Support\Facades\Auth;
use WeProDev\LaraPanel\Core\User\Domain\UserDomain;
use WeProDev\LaraPanel\Core\User\Dto\UserDto;
use WeProDev\LaraPanel\Core\User\Repository\UserRepositoryInterface;
use WeProDev\LaraPanel\Infrastructure\User\Model\User;
use WeProDev\LaraPanel\Infrastructure\User\Repository\Factory\UserFactory;

class UserEloquentRepository implements UserRepositoryInterface
{
    public function firstOrCreate(UserDto $userDto): UserDomain
    {
        $userModel = User::firstOrCreate([
            'email' => $userDto->getEmail(),
        ], [
            'first_name' => $userDto->getFirstName(),
            'last_name' => $userDto->getLastName(),
            'email' => $userDto->getEmail(),
            'status' => $userDto->getStatus()->value,
            'mobile' => $userDto->getMobile(),
            'password' => $userDto->getPassword(),
            'language' => $userDto->getLanguage()->value,
        ]);

        return UserFactory::fromEloquent($userModel);
    }

    public function findById(int $userId): UserDomain
    {
        $userModel = User::where(['id' => $userId])->firstOrFail();

        return UserFactory::fromEloquent($userModel);
    }

    public function assignRolesToUser(UserDomain $userDomain, array $rolesName): void
    {
        $userModel = User::where(['id' => $userDomain->getId()])->firstOrFail();

        $userModel->assignRole(['name' => $rolesName[0], 'team_id' => 1]);
    }

    public function signInUser(UserDomain $userDomain): void
    {
        $userModel = User::where(['id' => $userDomain->getId()])->firstOrFail();

        Auth::login($userModel);
    }
}
