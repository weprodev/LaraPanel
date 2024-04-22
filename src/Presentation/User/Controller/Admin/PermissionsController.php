<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Presentation\User\Controller\Admin;

use WeProDev\LaraPanel\Core\User\Repository\PermissionRepositoryInterface;
use WeProDev\LaraPanel\Infrastructure\User\Provider\UserServiceProvider;

class PermissionsController
{
    protected string $baseViewPath;

    private PermissionRepositoryInterface $permissionRepository;

    public function __construct()
    {
        $this->permissionRepository = resolve(PermissionRepositoryInterface::class);
        $this->baseViewPath = UserServiceProvider::$LPanel_Path.'.User.permission.';
    }

    public function index()
    {
        $permissions = $this->permissionRepository->paginate(config('larapanel.pagination'));

        return view($this->baseViewPath.'index', compact('permissions'));
    }

    public function create()
    {
        return view($this->baseViewPath.'create');
    }

    public function edit(int $permissionName)
    {
        // TODO
        if ($permission = $this->permissionRepository->find($ID)) {
            return view($this->baseViewPath.'edit', compact('permission'));
        }

        return redirect()->route('admin.user_management.permission.index')->with('message', [
            'type' => 'danger',
            'text' => "This permission << {$request->name} >> does not exist!",
        ]);
    }

    public function store(StorePermission $request)
    {
        $this->permissionRepository->store([
            'name' => $request->name,
            'title' => $request->title,
            'module' => $request->module,
            'guard_name' => $request->guard_name,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.user_management.permission.index')->with('message', [
            'type' => 'success',
            'text' => "This permission << {$request->name} >> created successfully!",
        ]);
    }

    public function update(int $ID, UpdatePermission $request)
    {
        if ($permission = $this->permissionRepository->find($ID)) {
            $this->permissionRepository->update($ID, [
                'name' => $request->name,
                'title' => $request->title,
                'module' => $request->module,
                'guard_name' => $request->guard_name,
                'description' => $request->description,
            ]);

            return redirect()->route('admin.user_management.permission.index')->with('message', [
                'type' => 'success',
                'text' => "This permission << {$request->name} >> updated successfully!",
            ]);
        }

        return redirect()->route('admin.user_management.permission.index')->with('message', [
            'type' => 'danger',
            'text' => "This permission << {$request->name} >> does not exist!",
        ]);
    }

    public function delete(int $ID)
    {
        if ($permission = $this->permissionRepository->find($ID)) {
            $name = $permission->name;
            $this->permissionRepository->delete($ID);

            return redirect()->route('admin.user_management.permission.index')->with('message', [
                'type' => 'warning',
                'text' => "This permission << {$name} >> deleted successfully!",
            ]);
        }

        return redirect()->route('admin.user_management.permission.index')->with('message', [
            'type' => 'danger',
            'text' => 'permission does not exist!',
        ]);
    }
}
