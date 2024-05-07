<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Presentation\User\Controller\Admin;

use WeProDev\LaraPanel\Core\User\Repository\RoleRepositoryInterface;
use WeProDev\LaraPanel\Core\User\Repository\UserRepositoryInterface;
use WeProDev\LaraPanel\Infrastructure\User\Provider\UserServiceProvider;

class UsersController
{
    protected string $baseViewPath;

    private UserRepositoryInterface $userRepository;

    private RoleRepositoryInterface $roleRepository;

    public function __construct()
    {
        $this->userRepository = resolve(UserRepositoryInterface::class);
        $this->roleRepository = resolve(RoleRepositoryInterface::class);
        $this->baseViewPath = UserServiceProvider::$LPanel_Path.'.User.user.';
    }

    public function index()
    {
        $users = $this->userRepository->paginate(config('larapanel.pagination'));

        return view($this->baseViewPath.'index', compact('users'));
    }

    public function create()
    {
        $roles = $this->roleRepository->all();
        // TODO
        // $groups = $this->departmentRepository->all();

        return view($this->baseViewPath.'create', compact('roles'));
    }

    public function edit($ID)
    {
        if ($user = $this->userRepository->find($ID)) {
            $roles = $this->roleRepository->all();
            // $departments = $this->departmentRepository->all(); // TODO
            // $userHasRoles = $user->roles ? array_column(json_decode($user->roles, true), 'id') : [];
            // $userHasDepartments = $user->departments ? array_column(json_decode($user->departments, true), 'id') : [];

            return view($this->baseViewPath.'edit', compact('roles'));
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
        $groups = $request->groups ?? [];

        $this->userRepository->assignRolesToUser($user, $roles);
        // $this->groupRepository->assignGroupsToUser($user, $groups);
        // $this->departmentRepository->attachDepartment($user, $departments);

        return redirect()->route('lp.admin.user.index')->with('message', [
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

            $this->userRepository->syncRoleToUser($user, $roles);
            $this->departmentRepository->syncDepartments($user, $departments);

            return redirect()->route('lp.admin.user.index')->with('message', [
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

            return redirect()->route('lp.admin.user.index')->with('message', [
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

            return redirect()->route('lp.admin.user.index')->with('message', [
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
