<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Presentation\User\Requests\Admin;

use WeProDev\LaraPanel\Presentation\Panel\Requests\RequestValidation;

class UpdateUser extends RequestValidation
{
    public function rules(): array
    {
        $userTable = config('laravel_user_management.users_table');
        $departmentTable = config('laravel_user_management.user_department_table');
        $tableNames = config('permission.table_names');

        return [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => "nullable|email|unique:{$userTable},email,".$this->ID,
            'mobile' => "required|unique:{$userTable},mobile,".$this->ID,
            'password' => 'nullable|min:6',
            'roles' => 'nullable|array',
            'roles.*' => 'nullable|exists:'.$tableNames['roles'].',name',
            'departments' => 'nullable|array',
            'departments.*' => "nullable|exists:{$departmentTable},id",
        ];
    }
}
