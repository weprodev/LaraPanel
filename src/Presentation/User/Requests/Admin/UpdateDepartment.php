<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Presentation\User\Requests\Admin;

use WeProDev\LaraPanel\Presentation\Panel\Requests\RequestValidation;

final class UpdateDepartment extends RequestValidation
{
    public function rules(): array
    {
        $table = config('laravel_user_management.user_department_table');

        return [
            'title' => "required|unique:{$table},title,".$this->ID,
            'parent_id' => "nullable|numeric|exists:{$table},id",
        ];
    }
}
