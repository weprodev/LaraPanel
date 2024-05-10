<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Core\Shared\Enum;

enum LanguageEnum: string
{
    case EN = 'EN';

    /**
     * @method static static[] cases()
     */
    public static function toArray(): array
    {
        return array_map(fn ($case) => $case->value, LanguageEnum::cases());
    }

    public static function default(): LanguageEnum
    {
        return LanguageEnum::tryFrom(config('larapanel.language.default')) ?? LanguageEnum::EN;
    }
}
