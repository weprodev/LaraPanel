<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Infrastructure\Shared\View;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

abstract class BaseComponent extends Component
{
    protected View $viewComponent;

    public function __construct(protected string $component)
    {
        $this->viewComponent = view(config('larapanel.view.components').'.'.$this->component);
    }

    public function render(): View
    {
        return $this->viewComponent;
    }
}
