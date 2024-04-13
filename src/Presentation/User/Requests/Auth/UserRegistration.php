<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Presentation\User\Requests\Auth;

use WeProDev\LaraPanel\Presentation\Panel\Requests\RequestValidation;

final class UserRegistration extends RequestValidation
{
    public function rules(): array
    {
        $username = config('laravel_user_management.auth.username');
        $userTable = config('laravel_user_management.users_table');

        return [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            "{$username}" => 'required'.($username == 'mobile' ? "|unique:{$userTable},mobile" : "|email|unique:{$userTable},email"),
            'password' => 'required|confirmed|min:6',
        ];
    }
}
