<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Presentation\User\Requests\Admin;

use WeProDev\LaraPanel\Presentation\Panel\Requests\RequestValidation;

final class StoreRole extends RequestValidation
{
    private array $table;

    public function setUp(): void
    {
        $this->table = config('permission.table_names');
    }

    public function rules(): array
    {
        return [
            'name' => 'required|unique:'.$this->table['roles'].',name',
            'title' => 'required|string',
            'guard_name' => 'nullable',
            'description' => 'nullable',
            'permissions' => 'nullable|array',
            'permissions.*' => 'nullable|exists:'.$this->table['permissions'].',name',
        ];
    }
}
