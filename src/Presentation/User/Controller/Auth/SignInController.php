<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Presentation\User\Controller\Auth;

use Auth;
use WeProDev\LaraPanel\Core\Shared\Enum\AlertTypeEnum;
use WeProDev\LaraPanel\Core\User\Enum\UserNameTypeEnum;
use WeProDev\LaraPanel\Core\User\Repository\UserRepositoryInterface;
use WeProDev\LaraPanel\Infrastructure\User\Provider\UserServiceProvider;
use WeProDev\LaraPanel\Presentation\User\Requests\Auth\SignInFormRequest;

class SignInController
{
    protected string $baseViewPath;

    private UserRepositoryInterface $userRepository;

    public function __construct()
    {
        if (!config('larapanel.auth.signin.enable')) {
            abort(404);
        }
        $this->userRepository = resolve(UserRepositoryInterface::class);
        $this->baseViewPath = UserServiceProvider::$LPanel_Path . '.User.auth.';
    }

    public function signInForm()
    {
        return view($this->baseViewPath . 'signin');
    }

    public function signIn(SignInFormRequest $request)
    {
        if (method_exists($this, 'customSignInHook')) {

            // @php-ignore  @phpstan-ignore-next-line
            return $this->customSignInHook($request);
        }

        $username = match (config('larapanel.auth.username')) {
            UserNameTypeEnum::MOBILE => 'mobile',
            default => 'email'
        };

        $credentials = [
            $username => $request->username,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            Auth::user();

            return redirect()->intended(config('larapanel.auth.default.redirection', '/'));
        }

        return redirect()->back()->with('message', [
            'type' => AlertTypeEnum::DANGER->value,
            'text' => __('Your username or password is wrong!'),
        ]);
    }

    public function signOut()
    {
        Auth::logout();

        return redirect('/');
    }
}
