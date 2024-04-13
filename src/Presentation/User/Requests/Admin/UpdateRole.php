<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Presentation\User\Requests\Admin;

use WeProDev\LaraPanel\Presentation\Panel\Requests\RequestValidation;

final class UpdateRole extends RequestValidation
{
    public function rules(): array
    {
        $tableNames = config('permission.table_names');

        return [
            'name' => 'required|unique:'.$tableNames['roles'].',name,'.$this->ID,
            'title' => 'required|string',
            'guard_name' => 'nullable',
            'description' => 'nullable',
            'permissions' => 'nullable|array',
            'permissions.*' => 'nullable|exists:'.$tableNames['permissions'].',name',
        ];
    }
}
