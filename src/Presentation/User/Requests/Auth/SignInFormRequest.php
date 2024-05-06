<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Presentation\User\Requests\Auth;

use WeProDev\LaraPanel\Core\User\Enum\UserNameTypeEnum;
use WeProDev\LaraPanel\Presentation\Panel\Requests\RequestValidation;

class SignInFormRequest extends RequestValidation
{
    public function rules(): array
    {
        $usernameValidation = match ($this->method) {
            UserNameTypeEnum::MOBILE->value => ['username' => 'required|min:10'],
            UserNameTypeEnum::EMAIL->value => ['username' => 'required|email'],
            default => ['username' => 'required']
        };

        return array_merge(['password' => 'required|string|min:6'], $usernameValidation);
    }
}
