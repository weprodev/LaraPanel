<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Presentation\User\Controller\Auth;

use WeProDev\LaraPanel\Core\Shared\Enum\AlertTypeEnum;
use WeProDev\LaraPanel\Core\Shared\Enum\LanguageEnum;
use WeProDev\LaraPanel\Core\User\Dto\UserDto;
use WeProDev\LaraPanel\Core\User\Enum\UserStatusEnum;
use WeProDev\LaraPanel\Core\User\Repository\RoleRepositoryInterface;
use WeProDev\LaraPanel\Core\User\Repository\TeamRepositoryInterface;
use WeProDev\LaraPanel\Core\User\Repository\UserRepositoryInterface;
use WeProDev\LaraPanel\Core\User\Service\RoleServiceInterface;
use WeProDev\LaraPanel\Infrastructure\User\Provider\UserServiceProvider;
use WeProDev\LaraPanel\Presentation\User\Requests\Auth\SignUpFormRequest;

class SignUpController
{
    protected string $baseViewPath;

    private UserRepositoryInterface $userRepository;

    private RoleServiceInterface $roleService;

    public function __construct()
    {
        if (!config('larapanel.auth.signup.enable')) {
            abort(404);
        }

        $this->userRepository = resolve(UserRepositoryInterface::class);
        $this->roleService = resolve(RoleServiceInterface::class);
        $this->baseViewPath = UserServiceProvider::$LPanel_Path . '.User.auth.';
    }

    public function signupForm()
    {
        return view($this->baseViewPath . 'signup');
    }

    public function signUp(SignUpFormRequest $request)
    {
        if (method_exists($this, 'customSignUpHook')) {

            // @php-ignore  @phpstan-ignore-next-line
            return $this->customSignUpHook($request);
        }

        $defaultRole = $this->roleService->getDefaultRole();

        $usrDto = UserDto::make(
            $request->email,
            $request->first_name,
            $request->last_name,
            $request->mobile ?? null,
            UserStatusEnum::PENDING,
            LanguageEnum::tryFrom(config('larapanel.language', LanguageEnum::default()->value)),
            $request->password
        );
        $user = $this->userRepository->firstOrCreate($usrDto);

        $this->userRepository->assignRolesToUser($user, [$defaultRole->getName()]);

        $this->userRepository->signInUser($user);

        return redirect()->route(config('larapanel.auth.default.redirection'))
            ->with('message', [
                'type' => AlertTypeEnum::SUCCESS,
                'text' => __('Your account has been created successfully!'),
            ]);
    }
}
