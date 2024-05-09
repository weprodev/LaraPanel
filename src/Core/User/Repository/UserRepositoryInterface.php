<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Core\User\Repository;

use Ramsey\Uuid\Rfc4122\UuidInterface;
use WeProDev\LaraPanel\Core\User\Domain\UserDomain;
use WeProDev\LaraPanel\Core\User\Dto\UserDto;

interface UserRepositoryInterface
{
    public function paginate(int $perPage);

    public function findById(int $userId): UserDomain;

    public function firstOrCreate(UserDto $userDto): UserDomain;

    public function create(UserDto $userDto): UserDomain;

    public function update(UserDomain $userDomain, UserDto $userDto): UserDomain;

    public function findBy(array $attributes): UserDomain;

    public function delete(UuidInterface $userUuid): void;

    /**
     * Assign list of roles to a user
     *
     * @param  array<int, string>  $rolesName
     */
    public function assignRolesToUser(UserDomain $userDomain, array $rolesName): void;

    public function assignGroupsToUser(UserDomain $userDomain, array $groupsId): void;

    public function signInUser(UserDomain $userDomain): void;

    public function syncRolesToUser(UserDomain $userDomain, array $roles = []): void;

    public function syncGroupsToUser(UserDomain $userDomain, array $groups = []): void;
}
