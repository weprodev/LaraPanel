<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Presentation\User\Controller\Admin;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
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

    public function edit(string $userUuid): View|RedirectResponse
    {
        if ($userDomain = $this->userRepository->findBy(['uuid' => $userUuid])) {

            return view($this->baseViewPath.'.edit')->with([
                'user' => $userDomain,
                'roles' => $this->roleRepository->all(),
                'userRoles' => $userDomain->getRoles()->pluck('id', 'id')->toArray(),
                'statuses' => UserStatusEnum::toArray(),
                'groups' => $this->groupRepository->all(),
                'userGroups' => $userDomain->getGroups()->pluck('id', 'id')->toArray(),
            ]);
        }

        return redirect()->back()->with('message', [
            'type' => AlertTypeEnum::DANGER->value,
            'text' => __('The user does not exist!'),
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
        if ($userDomain = $this->userRepository->findBy(['uuid' => $userUuid])) {
            $userDto = UserDto::make(
                $request->email,
                $request->first_name,
                $request->last_name,
                $request->mobile,
                UserStatusEnum::tryFrom($request->status),
                LanguageEnum::EN, // TODO
                $request->password,
            );
            $this->userRepository->update($userDomain, $userDto);

            $this->userRepository->syncRolesToUser($userDomain, $request->roles ?? []);
            $this->userRepository->syncGroupsToUser($userDomain, $request->groups ?? []);

            return redirect()->route('lp.admin.user.index')->with('message', [
                'type' => AlertTypeEnum::SUCCESS->value,
                'text' => __('The user :user has been successfully updated!', ['user' => $userDomain->getEmail()]),
            ]);
        }

        return redirect()->back()->with('message', [
            'type' => AlertTypeEnum::DANGER->value,
            'text' => __('The user does not exist!'),
        ]);
    }

    public function delete(string $userUuid)
    {
        if ($userDomain = $this->userRepository->findBy(['uuid' => $userUuid])) {
            $userEmail = $userDomain->getEmail();
            $this->userRepository->delete($userDomain->getUuid());

            return redirect()->route('lp.admin.user.index')->with('message', [
                'type' => AlertTypeEnum::WARNING->value,
                'text' => __('The user :user has been successfully deleted!', ['user' => $userEmail]),
            ]);
        }

        return redirect()->back()->with('message', [
            'type' => AlertTypeEnum::DANGER->value,
            'text' => __('The user does not exist!'),
        ]);
    }
}
