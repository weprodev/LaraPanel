<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Presentation\User\Controller\Admin;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use WeProDev\LaraPanel\Core\Shared\Enum\AlertTypeEnum;
use WeProDev\LaraPanel\Core\User\Dto\RoleDto;
use WeProDev\LaraPanel\Core\User\Enum\GuardTypeEnum;
use WeProDev\LaraPanel\Core\User\Repository\PermissionRepositoryInterface;
use WeProDev\LaraPanel\Core\User\Repository\RoleRepositoryInterface;
use WeProDev\LaraPanel\Infrastructure\Shared\Provider\SharedServiceProvider;
use WeProDev\LaraPanel\Presentation\User\Requests\Admin\StoreRoleRequest;
use WeProDev\LaraPanel\Presentation\User\Requests\Admin\UpdateRoleRequest;

class RolesController
{
    protected string $baseViewPath;

    private array $guards = [];

    private PermissionRepositoryInterface $permissionRepository;

    private RoleRepositoryInterface $roleRepository;

    public function __construct()
    {
        $this->permissionRepository = resolve(PermissionRepositoryInterface::class);
        $this->roleRepository = resolve(RoleRepositoryInterface::class);
        $this->baseViewPath = SharedServiceProvider::$LPanel_Path.'.User.role.';
        $this->guards = GuardTypeEnum::all();
    }

    public function index(): View
    {
        return view($this->baseViewPath.'index')->with([
            'roles' => $this->roleRepository->paginate(config('larapanel.pagination')),
        ]);
    }

    public function create(): View
    {
        return view($this->baseViewPath.'create')->with([
            'permissions' => $this->permissionRepository->getPermissionsModule(),
            'guards' => $this->guards,
            'defaultGuard' => GuardTypeEnum::default()->value,
        ]);
    }

    public function edit(int $roleId): View|RedirectResponse
    {
        if ($role = $this->roleRepository->findBy(['id' => $roleId])) {

            return view($this->baseViewPath.'edit')->with([
                'role' => $role,
                'guards' => $this->guards,
                'permissions' => $this->permissionRepository->getPermissionsModule(),
                'roleHasPermissions' => $role->getPermissions()->pluck('id', 'id')->toArray(),
            ]);
        }

        return redirect()->route('lp.admin.role.index')->with('message', [
            'type' => AlertTypeEnum::DANGER->value,
            'text' => __('The role does not exist!'),
        ]);
    }

    public function store(StoreRoleRequest $request)
    {
        $roleDto = RoleDto::make(
            $request->name,
            $request->title,
            $request->description,
            $request->guard_name ? GuardTypeEnum::getGuardType($request->guard_name ?? GuardTypeEnum::default()) : null,
        );
        $role = $this->roleRepository->create($roleDto);

        if (! empty($request->permissions)) {
            $this->permissionRepository->SyncPermToRole($role->getId(), $request->permissions);
        }

        return redirect()->route('lp.admin.role.index')->with('message', [
            'type' => AlertTypeEnum::SUCCESS->value,
            'text' => __('The role :role created successfully.', ['role' => $request->title]),
        ]);
    }

    public function update(int $roleId, UpdateRoleRequest $request)
    {
        if ($role = $this->roleRepository->findBy(['id' => $roleId])) {
            $roleDto = RoleDto::make(
                $role->getName(),
                $request->title,
                $request->description,
                $request->guard_name ? GuardTypeEnum::getGuardType($request->guard_name ?? GuardTypeEnum::default()) : null,
            );
            $this->roleRepository->update($role, $roleDto);

            $permissions = $request->permissions ?? [];
            $this->permissionRepository->SyncPermToRole($role->getId(), $permissions);

            return redirect()->route('lp.admin.role.index')->with('message', [
                'type' => AlertTypeEnum::SUCCESS->value,
                'text' => __('The role :role has been successfully updated!', ['role' => $role->getName()]),
            ]);
        }

        return redirect()->route('lp.admin.role.index')->with('message', [
            'type' => AlertTypeEnum::DANGER->value,
            'text' => __('The role does not exist!'),
        ]);
    }

    public function delete(int $roleId)
    {
        if ($role = $this->roleRepository->findBy(['id' => $roleId])) {
            $this->roleRepository->delete($roleId);

            return redirect()->route('lp.admin.role.index')->with('message', [
                'type' => AlertTypeEnum::WARNING->value,
                'text' => __('The role deleted successfully!'),
            ]);
        }

        return redirect()->route('lp.admin.role.index')->with('message', [
            'type' => AlertTypeEnum::DANGER->value,
            'text' => __('The role does not exist!'),
        ]);
    }
}
