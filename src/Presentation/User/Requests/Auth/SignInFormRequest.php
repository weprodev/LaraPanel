<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Presentation\User\Requests\Auth;

use WeProDev\LaraPanel\Core\User\Enum\UserNameTypeEnum;
use WeProDev\LaraPanel\Presentation\Panel\Requests\RequestValidation;

class SignInFormRequest extends RequestValidation
{
    public function rules(): array
    {
        $inputUserName = request('username');
        $validation = [
            'password' => 'required|string|min:6',
        ];

        if (config('larapanel.auth.username') == UserNameTypeEnum::BOTH->value) {
        }

        return $validation;
    }

    // TODO withValidation
}
