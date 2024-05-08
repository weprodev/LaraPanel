<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Presentation\User\Requests\Admin;

use WeProDev\LaraPanel\Presentation\Panel\Requests\RequestValidation;

class UpdateGroupRequest extends RequestValidation
{
    public function rules(): array
    {
        $table = config('larapanel.table.prefix').config('larapanel.table.group.name');

        return [
            'title' => 'nullable|string',
            'name' => "required|unique:{$table},name,".$this->groupId,
            'parent_id' => "nullable|numeric|exists:{$table},id",
            'description' => 'nullable|string',
        ];
    }
}
