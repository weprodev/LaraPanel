<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Presentation\User\Controller\Auth;

use Auth;
use WeProDev\LaraPanel\Core\User\Enum\UserStatusEnum;
use WeProDev\LaraPanel\Core\User\Repository\UserRepositoryInterface;
use WeProDev\LaraPanel\Infrastructure\User\Provider\UserServiceProvider;

class SignInController
{
    protected string $baseViewPath;

    private UserRepositoryInterface $userRepository;

    public function __construct()
    {
        if (! config('larapanel.auth.signin.enable')) {
            abort(404);
        }
        $this->userRepository = resolve(UserRepositoryInterface::class);
        $this->baseViewPath = UserServiceProvider::$LPanel_Path.'.User.auth.';
    }

    public function signInForm()
    {
        return view($this->baseViewPath.'signin');
    }

    public function signIn(UserLogin $request)
    {
        // TODO
        $username = config('larapanel.auth.username');
        $credentials = [$username => $request->{$username}, 'password' => $request->password, 'status' => 'accepted'];

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            return redirect()->intended('/');
        }

        $user = $this->userRepository->findBy(["{$username}" => $request->{$username}]);
        if ($user && $user->status != UserStatusEnum::ACCEPTED->value) {
            return redirect()->back()->with('message', [
                'type' => 'danger',
                'text' => trans('trans.your_account_does_not_activated'),
            ]);
        }

        return redirect()->back()->with('message', [
            'type' => 'danger',
            'text' => trans('trans.username_or_password_wrong'),
        ]);
    }

    public function signOut()
    {
        Auth::logout();

        return redirect('/');
    }
}
