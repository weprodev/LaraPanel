<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Infrastructure\User\Seeders\Role;

use Illuminate\Database\Seeder;
use WeProDev\LaraPanel\Core\User\Repository\RoleRepositoryInterface;

class MasterRoleTableSeeder extends Seeder
{
    protected $roles = [];

    public function __construct(private RoleRepositoryInterface $roleRepository)
    {
    }

    protected function getRoles()
    {
        return $this->roles;
    }

    public function run(): void
    {
        $this->command->info('=================');
        $this->command->info('LaraPanel: Insert Roles Data');
        $this->command->info('Add new role in "database/seeders/RoleSeeder.php"');
        $this->command->info("=================\n");

        foreach ($this->getRoles() as $role) {
            $findRole = $this->roleRepository->findBy([
                'name' => $role['name'],
                'guard_name' => $role['guard_name'],
            ]);

            if ($findRole) {
                $this->command->info(
                    'THIS ROLE << '.
                        $role['name'].
                        '['.
                        $role['guard_name'].
                        '] >> EXISTED! UPDATING DATA ...'
                );

                $this->roleRepository->update($findRole->id, [
                    'name' => $role['name'],
                    'title' => $role['title'],
                    'guard_name' => $role['guard_name'],
                    'description' => isset($role['description'])
                        ? $role['description']
                        : null,
                ]);

                continue;
            }

            $this->command->info(
                'CREATING THIS ROLE <<'.
                    $role['name'].
                    '['.
                    $role['guard_name'].
                    '] >> ...'
            );

            $this->roleRepository->store([
                'name' => $role['name'],
                'title' => $role['title'],
                'guard_name' => $role['guard_name'],
                'description' => isset($role['description'])
                    ? $role['description']
                    : null,
            ]);
        }

        $this->command->info("\nThe roles data has been successfully updated!");
        $this->command->info("=============================================================\n");
    }
}
