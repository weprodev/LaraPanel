<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Presentation\User\Requests\Admin;

use WeProDev\LaraPanel\Core\User\Enum\GuardTypeEnum;
use WeProDev\LaraPanel\Presentation\Panel\Requests\RequestValidation;

class StorePermissionRequest extends RequestValidation
{
    public function rules(): array
    {
        $table = config('permission.table_names');
        $guardNames = implode(',', GuardTypeEnum::all() ?? []);
        $modules = implode(',', config('larapanel.permission.module.list', []));

        return [
            'name' => 'required|unique:' . $table['permissions'],
            'title' => 'nullable|string',
            'module' => 'required|string|in:' . $modules,
            'guard_name' => 'nullable|string|in:' . $guardNames,
            'description' => 'nullable|string',
        ];
    }
}
