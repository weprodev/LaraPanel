<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Presentation\User\Requests\Auth;

use WeProDev\LaraPanel\Core\User\Enum\UserNameTypeEnum;
use WeProDev\LaraPanel\Presentation\Panel\Requests\RequestValidation;

class SignUpFormRequest extends RequestValidation
{
    public function rules(): array
    {
        $usersTable = config('larapanel.table.prefix').config('larapanel.table.user.name');
        $validation = [
            'first_name' => 'required|string|min:2',
            'last_name' => 'required|string|min:2',
            'password' => 'required|confirmed|min:6',
            'email' => "required|string|unique:{$usersTable},email",
        ];

        if (config('larapanel.auth.username') != UserNameTypeEnum::EMAIL->value) {
            $validation = array_merge($validation, [
                'mobile' => "required|string|min:9|unique:{$usersTable},mobile",
            ]);
        }

        return $validation;
    }
}
