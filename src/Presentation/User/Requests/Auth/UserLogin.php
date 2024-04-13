<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Presentation\User\Requests\Auth;

use WeProDev\LaraPanel\Presentation\Panel\Requests\RequestValidation;

final class UserLogin extends RequestValidation
{
    public function rules(): array
    {
        $username = config('laravel_user_management.auth.username');

        return [
            "{$username}" => 'required'.($username == 'mobile' ? '|numeric' : '|email'),
            'password' => 'required',
        ];
    }
}
