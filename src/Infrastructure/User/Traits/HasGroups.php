<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Infrastructure\User\Traits;

trait HasGroups
{
    // TODO
    /**
     * A model may have multiple groups.
     */
    // public function groups()
    // {
    // }

    public function assignGroup(...$groups) {}

    public function syncGroups(array $groupIds)
    {
        $this->groups()->sync($groupIds);
    }

    public function hasGroup($groups, ?string $guard = null): bool
    {
        return true;
    }
}
