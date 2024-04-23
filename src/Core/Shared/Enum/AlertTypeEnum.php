<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Core\Shared\Enum;

enum AlertTypeEnum: string
{
    case SUCCESS = 'success';

    case WARNING = 'warning';

    public function __toString(): string
    {
        return $this->value;
    }
}
