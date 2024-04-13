<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Core\User\Enum;

enum RolesEnum: string
{
    case WRITER = 'writer';
    case EDITOR = 'editor';
    case USER_MANAGER = 'user-manager';
    case Admin = 'admin';

    public function details(): array
    {
        return match ($this) {
            self::WRITER => [
                'name' => self::WRITER,
                'title' => 'Writer',
                'description' => '',
            ],
            self::EDITOR => [
                'name' => self::EDITOR,
                'title' => 'Editor',
                'description' => '',
            ],
            self::USER_MANAGER => [
                'name' => self::USER_MANAGER,
                'title' => 'User Manager',
                'description' => '',
            ],
            self::Admin => [
                'name' => self::Admin,
                'title' => 'Super Admin',
                'description' => '',
            ],
        };
    }
}
