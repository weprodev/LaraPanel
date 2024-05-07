<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Infrastructure\Shared\Helper;

final class BreadcrumbHelper
{
    public static function generateLink(array $item): string
    {
        if (isset($item['url'])) {
            return $item['url'];
        }

        if (isset($item['route'])) {

            if (isset($item['param'])) {
                return route($item['route'], $item['param']);
            }

            return route($item['route']);
        }

        return '#';
    }
}
