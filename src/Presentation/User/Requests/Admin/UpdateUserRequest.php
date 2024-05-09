<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Presentation\User\Requests\Admin;

use WeProDev\LaraPanel\Presentation\Panel\Requests\RequestValidation;

class UpdateUserRequest extends RequestValidation
{
    public function rules(): array
    {
        $prefixTable = config('larapanel.table.prefix');
        $userTable = $prefixTable.config('larapanel.table.user.name');
        $groupTable = $prefixTable.config('larapanel.table.group.name');
        $permissionTable = config('permission.table_names');

        return [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => "required|email|unique:{$userTable},email,{$this->userUuid},uuid",
            'mobile' => "required|unique:{$userTable},mobile,{$this->userUuid},uuid",
            'password' => 'nullable|min:6',
            'roles' => 'nullable|array',
            'roles.*' => 'nullable|exists:'.$permissionTable['roles'].',name',
            'groups' => 'nullable|array',
            'groups.*' => "nullable|exists:{$groupTable},id",
        ];
    }
}
