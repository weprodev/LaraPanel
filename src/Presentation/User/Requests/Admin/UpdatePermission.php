<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Presentation\User\Requests\Admin;

use WeProDev\LaraPanel\Presentation\Panel\Requests\RequestValidation;

final class UpdatePermission extends RequestValidation
{
    public function rules(): array
    {
        $tableNames = config('permission.table_names');

        return [
            'name' => 'required|unique:'.$tableNames['permissions'].',name,'.$this->ID,
            'title' => 'required|string',
            'module' => 'nullable',
            'guard_name' => 'nullable',
            'description' => 'nullable',
        ];
    }
}
