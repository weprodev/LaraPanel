<?php

declare(strict_types=1);

namespace WeProDev\LaraPanel\Presentation\Panel\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class RequestValidation extends FormRequest
{
    public function __construct(
        array $query = [],
        array $request = [],
        array $attributes = [],
        array $cookies = [],
        array $files = [],
        array $server = [],
        $content = null
    ) {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
        $this->setUp();
    }

    abstract public function rules(): array;

    public function authorize(): bool
    {
        return true;
    }

    protected function setUp(): void {}
}
