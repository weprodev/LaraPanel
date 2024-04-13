<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Presentation\User\Requests\Admin;

use WeProDev\LaraPanel\Presentation\Panel\Requests\RequestValidation;

final class StorePermission extends RequestValidation
{
    private array $table;

    public function setUp(): void
    {
        $this->table = config('permission.table_names');
    }

    public function rules(): array
    {
        return [
            'name' => 'required|unique:'.$this->table['permissions'],
            'title' => 'required|string',
            'module' => 'nullable',
            'guard_name' => 'nullable',
            'description' => 'nullable',
        ];
    }
}
