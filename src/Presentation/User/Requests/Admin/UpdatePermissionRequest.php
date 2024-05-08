<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Presentation\User\Requests\Admin;

use WeProDev\LaraPanel\Core\User\Enum\GuardTypeEnum;
use WeProDev\LaraPanel\Presentation\Panel\Requests\RequestValidation;

class UpdatePermissionRequest extends RequestValidation
{
    public function rules(): array
    {
        $guardNames = implode(',', GuardTypeEnum::all() ?? []);
        $modules = implode(',', config('larapanel.permission.module.list', []));

        return [
            'title' => 'nullable|string',
            'module' => 'required|string|in:' . $modules,
            'guard_name' => 'nullable|string|in:' . $guardNames,
            'description' => 'nullable|string',
        ];
    }
}
