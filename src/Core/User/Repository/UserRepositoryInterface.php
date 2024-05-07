<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Core\User\Repository;

use WeProDev\LaraPanel\Core\User\Domain\UserDomain;
use WeProDev\LaraPanel\Core\User\Dto\UserDto;

interface UserRepositoryInterface
{
    public function paginate(int $perPage);

    public function findById(int $userId): UserDomain;

    public function firstOrCreate(UserDto $userDto): UserDomain;

    public function findBy(array $attributes): UserDomain;

    /**
     * Assign list of roles to a user
     *
     * @param  array<int, string>  $rolesName
     */
    public function assignRolesToUser(UserDomain $userDomain, array $rolesName): void;

    public function signInUser(UserDomain $userDomain): void;

    public function syncRoleToUser(UserDomain $userDomain, array $roles = []): void;
}
