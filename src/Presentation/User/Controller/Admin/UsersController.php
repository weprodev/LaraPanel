<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Presentation\User\Controller\Admin;

use WeProDev\LaraPanel\Core\User\Repository\RoleRepositoryInterface;
use WeProDev\LaraPanel\Core\User\Repository\UserRepositoryInterface;

class UsersController
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly RoleRepositoryInterface $roleRepository
    ) {
    }

    public function index()
    {
        $users = $this->userRepository->allWithTrashed();

        return view('user-management.user.index', compact('users'));
    }

    public function create()
    {
        $roles = $this->roleRepository->all();
        $departments = $this->departmentRepository->all();

        return view('user-management.user.create', compact('roles', 'departments'));
    }

    public function edit($ID)
    {
        if ($user = $this->userRepository->find($ID)) {
            $roles = $this->roleRepository->all();
            $departments = $this->departmentRepository->all();
            $userHasRoles = $user->roles ? array_column(json_decode($user->roles, true), 'id') : [];
            $userHasDepartments = $user->departments ? array_column(json_decode($user->departments, true), 'id') : [];

            return view('user-management.user.edit', compact('roles', 'departments', 'user', 'userHasRoles', 'userHasDepartments'));
        }

        return redirect()->back()->with('message', [
            'type' => 'danger',
            'text' => 'This user does not exist!',
        ]);
    }

    public function store(StoreUser $request)
    {
        $user = $this->userRepository->store([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'status' => $request->status ?? 'pending',
            'password' => $request->password,
        ]);

        $roles = $request->roles ?? [];
        $departments = $request->departments ?? [];

        $this->roleRepository->setRoleToMember($user, $roles);
        $this->departmentRepository->attachDepartment($user, $departments);

        return redirect()->route('admin.user_management.user.index')->with('message', [
            'type' => 'success',
            'text' => 'َUser updated successfully!',
        ]);
    }

    public function update(int $ID, UpdateUser $request)
    {

        if ($user = $this->userRepository->find($ID)) {
            $this->userRepository->update($ID, [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'status' => $request->status,
                'mobile' => $request->mobile,
            ]);

            $roles = $request->roles ?? [];

            $departments = $request->departments ?? [];
            if (count($departments) == 1 && $departments[0] == null) {
                $departments = [];
            }
            //// IF WE WANT TO CHANGE PASSWORD
            ////////////////////////////////////////////////////////////
            if ($request->password) {
                $this->userRepository->update($ID, [
                    'password' => bcrypt($request->password),
                ]);
            }
            ////////////////////////////////////////////////////////////

            $this->roleRepository->syncRoleToUser($user, $roles);
            $this->departmentRepository->syncDepartments($user, $departments);

            return redirect()->route('admin.user_management.user.index')->with('message', [
                'type' => 'success',
                'text' => 'َUser updated successfully!',
            ]);
        }

        return redirect()->back()->with('message', [
            'type' => 'danger',
            'text' => 'This user does not exist!',
        ]);
    }

    public function delete($ID)
    {
        if ($user = $this->userRepository->find($ID)) {
            //// soft delete
            $this->userRepository->update($ID, [
                'status' => 'deleted',
            ]);
            $user->delete();

            return redirect()->route('admin.user_management.user.index')->with('message', [
                'type' => 'warning',
                'text' => 'User Deleted successfully!',
            ]);
        }

        return redirect()->back()->with('message', [
            'type' => 'danger',
            'text' => 'This user does not exist!',
        ]);
    }

    public function restoreBackUser(int $ID)
    {

        if ($this->userRepository->restoreUser($ID)) {
            $user = $this->userRepository->update($ID, [
                'status' => 'accepted',
            ]);

            return redirect()->route('admin.user_management.user.index')->with('message', [
                'type' => 'success',
                'text' => 'User restored successfully!',
            ]);
        }

        return redirect()->back()->with('message', [
            'type' => 'danger',
            'text' => 'This user does not exist!',
        ]);
    }
}
