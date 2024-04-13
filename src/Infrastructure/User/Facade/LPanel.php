<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Infrastructure\User\Facade;

use Illuminate\Support\Facades\Facade;

final class LPanel extends Facade
{
    public static function getFacadeAccessor(): string
    {
        return 'LPanel';
    }
}
