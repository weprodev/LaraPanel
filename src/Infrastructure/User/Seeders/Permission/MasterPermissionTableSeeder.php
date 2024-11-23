<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Infrastructure\User\Seeders\Permission;

use Illuminate\Database\Seeder;
use WeProDev\LaraPanel\Core\User\Dto\PermissionDto;
use WeProDev\LaraPanel\Core\User\Enum\GuardTypeEnum;
use WeProDev\LaraPanel\Core\User\Repository\PermissionRepositoryInterface;
use WeProDev\LaraPanel\Core\User\Repository\RoleRepositoryInterface;

class MasterPermissionTableSeeder extends Seeder
{
    protected $permissions = [];

    protected $guardName = 'web';

    public function __construct(
        private PermissionRepositoryInterface $permissionRepository,
        private RoleRepositoryInterface $roleRepository
    ) {}

    protected function getPermissions()
    {
        return $this->permissions;
    }

    public function run(): void
    {
        $this->command->info('=================');
        $this->command->info('LaraPanel: Insert Permission Data');
        $this->command->info('Add new permission in "database/seeders/PermissionSeeder.php"');
        $this->command->info("=================\n");

        $rolePermissions = [];

        foreach ($this->getPermissions() as $permission) {

            /// WHEN WE NEED A PERMISSION FOR DIFFERENT GUARD NAMES
            //////////////////////////////////////////////////////////
            if (is_array($permission['guard_name'])) {
                foreach ($permission['guard_name'] as $guard) {
                    $rolePermissions = $this->setPermissions(
                        $permission,
                        $guard
                    );

                    $this->command->info(
                        '  THIS PERMISSION <<'.
                            array_keys($rolePermissions)[0].
                            ' >> ASSIGNED TO THESE ROLES <<<< '.
                            implode(
                                ' - ',
                                $rolePermissions[array_keys($rolePermissions)[0]]
                            ).
                            ' >>> GUARD NAME = '.
                            $guard
                    );
                    $permObject = $this->permissionRepository->findBy([
                        'name' => array_keys($rolePermissions)[0],
                        'guard_name' => $guard,
                    ]);

                    $this->syncRolesToPermission(
                        $permObject->getName(),
                        $rolePermissions[array_keys($rolePermissions)[0]],
                        $guard
                    );
                }

                continue;
            }

            $rolePermissions = $this->setPermissions(
                $permission,
                $permission['guard_name']
            );
            $this->guardName = $permission['guard_name'];

            /*
            |--------------------------------------------------------------------------
            |  UPDATE ROLE'S PERMISSIONS
            |--------------------------------------------------------------------------
            |
            */

            if (! empty($rolePermissions)) {
                $this->command->info("\n");
                $this->command->info(
                    '        *********************************************        '
                );
                $this->command->info(
                    '               UPDATING ROLE\'S PERMISSIONS                  '
                );
                $this->command->info(
                    '        *********************************************        '
                );
                $this->command->info("\n");
                foreach ($rolePermissions as $perm => $roles) {
                    $this->command->info(
                        '  THIS PERMISSION <<'.
                            $perm.
                            ' >> ASSIGNED TO THESE ROLES <<<< '.
                            implode(' - ', $roles).
                            ' >>> GUARD NAME = '.
                            $this->guardName
                    );
                    $permObject = $this->permissionRepository->findBy([
                        'name' => $perm,
                    ]);

                    $this->syncRolesToPermission($permObject->getName(), $roles, $this->guardName);
                }

                $this->command->info("\n");
                $this->command->info(
                    '        *********************************************        '
                );
                $this->command->info(
                    '           FINALIZED UPDATING ROLE\'S PERMISSIONS            '
                );
                $this->command->info(
                    '        *********************************************        '
                );
            }
        }

        $this->command->info("\nThe permissions data has been successfully updated!");
        $this->command->info("=============================================================\n");
    }

    private function setPermissions(array $permission, $guard = null)
    {
        $getGuard = $guard ?? $permission['guard_name'];
        $getPermission = $this->permissionRepository->findBy([
            'name' => $permission['name'],
            'guard_name' => $getGuard,
        ]);

        $permissionDto = PermissionDto::make(
            $permission['name'],
            $permission['title'] ?? $permission['name'],
            $permission['module'] ?? config('larapanel.permission.module.default'),
            $permission['description'] ?? null,
            GuardTypeEnum::getGuardType($guard ?? $permission['guard_name'])
        );

        if (! is_null($getPermission)) {
            $this->command->info(
                'THIS PERMISSION << '.
                    $permission['name'].
                    ' >> EXISTED! UPDATING DATA ...'
            );

            $this->permissionRepository->update($getPermission, $permissionDto);

            $rolePermissions[$permission['name']] =
                array_values($permission['roles']) ?? null;

            return $rolePermissions;
        }

        $this->command->info(
            'CREATING THIS PERMISSION <<'.$permission['name'].' >> ...'
        );

        $permissionDto = PermissionDto::make(
            $permission['name'],
            $permission['title'] ?? $permission['name'],
            $permission['module'] ?? config('larapanel.permission.module.default'),
            $permission['description'] ?? null,
            GuardTypeEnum::getGuardType($guard ?? $permission['guard_name'])
        );

        $this->permissionRepository->create($permissionDto);

        $rolePermissions[$permission['name']] =
            array_values($permission['roles']) ?? null;

        return $rolePermissions;
    }

    private function syncRolesToPermission(string $permission, array $roles, string $guard): void
    {
        foreach ($roles as $role) {
            $findRole = $this->roleRepository->findBy([
                'name' => $role,
                'guard_name' => $guard,
            ]);

            if ($findRole) {
                $this->permissionRepository->setPermissionToRole(
                    $findRole->getId(),
                    $permission
                );
            }
        }
    }
}
