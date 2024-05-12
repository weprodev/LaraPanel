<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Presentation\User\Requests\Admin;

use WeProDev\LaraPanel\Core\User\Enum\GuardTypeEnum;
use WeProDev\LaraPanel\Presentation\Panel\Requests\RequestValidation;

class StoreRoleRequest extends RequestValidation
{
    public function rules(): array
    {
        $table = config('permission.table_names');
        $guardNames = implode(',', GuardTypeEnum::all() ?? []);

        return [
            'name' => 'required|unique:'.$table['roles'].',name',
            'title' => 'required|string',
            'guard_name' => 'nullable|string|in:'.$guardNames,
            'description' => 'nullable|string',
            'permissions' => 'nullable|array',
            'permissions.*' => 'nullable|exists:'.$table['permissions'].',name',
        ];
    }
}
