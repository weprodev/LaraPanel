<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Presentation\User\Requests\Admin;

use WeProDev\LaraPanel\Presentation\Panel\Requests\RequestValidation;

class StoreGroupRequest extends RequestValidation
{
    public function rules(): array
    {
        $table = config('larapanel.table.prefix').config('larapanel.table.group.name');

        return [
            'title' => 'nullable|string',
            'name' => "required|string|unique:{$table},name",
            'parent_id' => "nullable|numeric|exists:{$table},id",
            'description' => 'nullable|string',
        ];
    }
}
