<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Presentation\User\Controller\Admin;

use WeProDev\LaraPanel\Core\User\Repository\PermissionRepositoryInterface;
use WeProDev\LaraPanel\Core\User\Repository\RoleRepositoryInterface;
use WeProDev\LaraPanel\Infrastructure\User\Provider\UserServiceProvider;

class RolesController
{
    protected string $baseViewPath;

    private PermissionRepositoryInterface $permissionRepository;

    private RoleRepositoryInterface $roleRepository;

    public function __construct()
    {
        $this->permissionRepository = resolve(PermissionRepositoryInterface::class);
        $this->roleRepository = resolve(RoleRepositoryInterface::class);
        $this->baseViewPath = UserServiceProvider::$LPanel_Path.'.User.role.';
    }

    public function index()
    {
        $roles = $this->roleRepository->paginate(config('larapanel.pagination'));

        return view($this->baseViewPath.'index', compact('roles'));
    }

    public function create()
    {
        $permissions = $this->permissionRepository->all();

        return view($this->baseViewPath.'create', compact('permissions'));
    }

    public function edit(int $ID)
    {
        if ($role = $this->roleRepository->find($ID)) {
            $permissions = $this->permissionRepository->all();
            $roleHasPermissions = array_column(json_decode($role->permissions, true), 'id');

            return view($this->baseViewPath.'edit', compact('role', 'permissions', 'roleHasPermissions'));
        }

        return redirect()->route('admin.user_management.role.index')->with('message', [
            'type' => 'danger',
            'text' => 'This role does not exist!',
        ]);
    }

    public function store(StoreRole $request)
    {
        $role = $this->roleRepository->store([
            'name' => $request->name,
            'title' => $request->title,
            'guard_name' => $request->guard_name,
            'description' => $request->description,
        ]);

        if (! empty($request->permissions)) {
            $this->permissionRepository->setPermissionToRole($role->id, $request->permissions);
        }

        return redirect()->route('admin.user_management.role.index')->with('message', [
            'type' => 'success',
            'text' => "his role << {$request->name} >> created successfully.",
        ]);
    }

    public function update(int $ID, UpdateRole $request)
    {
        if ($role = $this->roleRepository->find($ID)) {
            $this->roleRepository->update($ID, [
                'name' => $request->name,
                'title' => $request->title,
                'guard_name' => $request->guard_name,
                'description' => $request->description,
            ]);

            $permissions = $request->permissions ?? [];
            $this->permissionRepository->SyncPermToRole($role->id, $permissions);

            return redirect()->route('admin.user_management.role.index')->with('message', [
                'type' => 'success',
                'text' => "This role << {$request->name} >> updated successfully.",
            ]);
        }

        return redirect()->route('admin.user_management.role.index')->with('message', [
            'type' => 'danger',
            'text' => 'This role does not exist!',
        ]);
    }

    public function delete(int $ID)
    {
        if ($this->roleRepository->find($ID)) {
            $this->roleRepository->delete($ID);

            return redirect()->route('admin.user_management.role.index')->with('message', [
                'type' => 'warning',
                'text' => 'Role deleted successfully!',
            ]);
        }

        return redirect()->route('admin.user_management.role.index')->with('message', [
            'type' => 'danger',
            'text' => 'This role does not exist!',
        ]);
    }
}
