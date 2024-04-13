<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Presentation\User\Requests\Admin;

use WeProDev\LaraPanel\Presentation\Panel\Requests\RequestValidation;

final class StoreUser extends RequestValidation
{
    private array $permissionTable;

    private string $userTable;

    private string $departmentTable;

    public function setUp(): void
    {
        $this->userTable = config('laravel_user_management.users_table');
        $this->departmentTable = config('laravel_user_management.user_department_table');
        $this->permissionTable = config('permission.table_names');
    }

    public function rules(): array
    {
        return [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => "nullable|email|unique:{$this->userTable},email",
            'mobile' => "required|unique:{$this->userTable},mobile",
            'password' => 'required|min:6',
            'roles' => 'nullable|array',
            'roles.*' => 'nullable|exists:'.$this->permissionTable['roles'].',name',
            'departments' => 'nullable|array',
            'departments.*' => "nullable|exists:{$this->departmentTable},id",
        ];
    }
}
