<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Presentation\User\Controller\Auth;

use Auth;
use WeProDev\LaraPanel\Core\User\Enum\UserStatusEnum;
use WeProDev\LaraPanel\Core\User\Repository\RoleRepositoryInterface;
use WeProDev\LaraPanel\Core\User\Repository\UserRepositoryInterface;
use WeProDev\LaraPanel\Infrastructure\User\Provider\UserServiceProvider;
use WeProDev\LaraPanel\Presentation\User\Requests\Auth\SignUpFormRequest;

class SignUpController
{
    protected string $baseViewPath;

    private UserRepositoryInterface $userRepository;

    private RoleRepositoryInterface $roleRepository;

    public function __construct()
    {
        if (! config('larapanel.auth.signup.enable')) {
            abort('404');
        }

        $this->userRepository = resolve(UserRepositoryInterface::class);
        $this->roleRepository = resolve(RoleRepositoryInterface::class);
        $this->baseViewPath = UserServiceProvider::$LPanel_Path.'.User.auth.';
    }

    public function signupForm()
    {
        return view($this->baseViewPath.'signup');
    }

    public function signUp(SignUpFormRequest $request)
    {
        if (method_exists($this, 'customSignUpHook')) {

            // @php-ignore  @phpstan-ignore-next-line
            return $this->customSignUpHook($request);
        }

        $userDefaultRole = $this->roleRepository->findBy([
            'name' => config('larapanel.auth.default_role'),
        ]);

        if (! $userDefaultRole) {
            return redirect()->back()->with('message', [
                'type' => 'danger',
                'text' => trans('trans.default_role_does_not_exist'),
            ]);
        }

        //// FOR ACTIVE ACCOUNT BASE PROJECT CONFIG ONE OF THE FIELDS [MOBILE, EMAIL] SHOULD BE REQUIRED
        $user = $this->userRepository->store([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => $request->password,
            'mobile' => $request->mobile,
            'status' => UserStatusEnum::PENDING->value,
        ]);

        /// ASSIGN DEFAULT ROLE TO USER
        $this->roleRepository->setRoleToMember($user, $userDefaultRole);

        Auth::login($user);

        return redirect()->route(config('larapanel.auth.redirection_home_route'))
            ->with('message', [
                'type' => 'success',
                'text' => trans('trans.account_created_successfully'),
            ]);
    }
}
