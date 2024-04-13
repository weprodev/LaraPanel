<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Core\User\Enum;

enum TeamsEnum: string
{
    case DEFAULT = 'default';

    public function details(): array
    {
        return match ($this) {
            self::WRITER => [
                'name' => self::WRITER,
                'title' => 'Writer',
                'description' => '',
                'module' => 'User',
            ],
        };
    }
}
