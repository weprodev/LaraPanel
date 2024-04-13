<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Presentation\User\Controller\Admin;

use Illuminate\Http\Request;
use WeProDev\LaraPanel\Core\User\Repository\PermissionRepositoryInterface;

class PermissionsController
{
    public function __construct(private readonly PermissionRepositoryInterface $permissionRepository)
    {
    }

    public function index(Request $request)
    {
        $permissions = $this->permissionRepository->paginate(config('laravel_user_management.row_list_per_page'));

        return view('user-management.permission.index', compact('permissions'));
    }

    public function create()
    {
        return view('user-management.permission.create');
    }

    public function edit(int $ID)
    {
        if ($permission = $this->permissionRepository->find($ID)) {
            return view('user-management.permission.edit', compact('permission'));
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
