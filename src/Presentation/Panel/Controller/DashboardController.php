<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Presentation\Panel\Controller;

use Illuminate\Contracts\View\View;
use WeProDev\LaraPanel\Infrastructure\Shared\Provider\SharedServiceProvider;

class DashboardController
{
    protected string $baseViewPath;

    public function __construct()
    {
        $this->baseViewPath = SharedServiceProvider::$LPanel_Path.'.'.config('larapanel.theme');
    }

    public function index(): View
    {
        return view("{$this->baseViewPath}.dashboard");
    }
}
