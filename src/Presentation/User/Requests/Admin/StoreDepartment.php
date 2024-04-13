<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Presentation\User\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreDepartment extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $table = config('laravel_user_management.user_department_table');

        return [
            'title' => "required|unique:{$table},title",
            'parent_id' => "nullable|numeric|exists:{$table},id",
        ];
    }
}
