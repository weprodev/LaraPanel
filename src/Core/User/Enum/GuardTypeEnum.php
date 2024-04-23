<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Core\User\Enum;

enum GuardTypeEnum: string
{
    case WEB = 'web';

    case API = 'api';
}
