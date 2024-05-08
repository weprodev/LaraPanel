<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Presentation\User\Controller\Admin;

use Illuminate\Contracts\View\View;
use WeProDev\LaraPanel\Core\Shared\Enum\AlertTypeEnum;
use WeProDev\LaraPanel\Core\Shared\Enum\LanguageEnum;
use WeProDev\LaraPanel\Core\User\Dto\UserDto;
use WeProDev\LaraPanel\Core\User\Enum\UserStatusEnum;
use WeProDev\LaraPanel\Core\User\Repository\GroupRepositoryInterface;
use WeProDev\LaraPanel\Core\User\Repository\RoleRepositoryInterface;
use WeProDev\LaraPanel\Core\User\Repository\UserRepositoryInterface;
use WeProDev\LaraPanel\Infrastructure\User\Provider\UserServiceProvider;
use WeProDev\LaraPanel\Presentation\User\Requests\Admin\StoreUserRequest;
use WeProDev\LaraPanel\Presentation\User\Requests\Admin\UpdateUserRequest;

class UsersController
{
    protected string $baseViewPath;

    private UserRepositoryInterface $userRepository;

    private RoleRepositoryInterface $roleRepository;

    private GroupRepositoryInterface $groupRepository;

    public function __construct()
    {
        $this->userRepository = resolve(UserRepositoryInterface::class);
        $this->roleRepository = resolve(RoleRepositoryInterface::class);
        $this->groupRepository = resolve(GroupRepositoryInterface::class);
        $this->baseViewPath = UserServiceProvider::$LPanel_Path.'.User.user.';
    }

    public function index(): View
    {
        $users = $this->userRepository->paginate(config('larapanel.pagination'));

        return view($this->baseViewPath.'index', compact('users'));
    }

    public function create(): View
    {
        return view($this->baseViewPath.'create')->with([
            'statuses' => UserStatusEnum::toArray(),
            'roles' => $this->roleRepository->all(),
            'groups' => $this->groupRepository->all(),
        ]);
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

    public function store(StoreUserRequest $request)
    {
        $userDto = UserDto::make(
            $request->email,
            $request->first_name,
            $request->last_name,
            $request->mobile,
            UserStatusEnum::tryFrom($request->status),
            LanguageEnum::EN, // TODO
            $request->password,
        );
        $user = $this->userRepository->create($userDto);

        if (! empty($request->roles)) {
            $this->userRepository->assignRolesToUser($user, $request->roles);
        }

        if (! empty($request->groups)) {
            $this->userRepository->assignGroupsToUser($user, $request->groups);
        }

        return redirect()->route('lp.admin.user.index')->with('message', [
            'type' => AlertTypeEnum::SUCCESS->value,
            'text' => __('The user :user has been successfully created!', ['user' => $request->email]),
        ]);
    }

    public function update(string $userUuid, UpdateUserRequest $request)
    {
        if ($user = $this->userRepository->findBy(['uuid' => $userUuid])) {
            $userDto = UserDto::make(
                $request->email,
                $request->first_name,
                $request->last_name,
                $request->mobile,
                UserStatusEnum::tryFrom($request->status),
                LanguageEnum::EN, // TODO
                $request->password,
            );
            $this->userRepository->update($user, $userDto);

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
