<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Core\User\Enum;

enum UserNameTypeEnum: string
{
    case EMAIL = 'EMAIL';

    case MOBILE = 'MOBILE';

    case BOTH = 'BOTH';
}
