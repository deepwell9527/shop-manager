<?php

namespace Deepwell\Data\Attributes\Validation;

use Attribute;
use Deepwell\Data\Support\Validation\References\RouteParameterReference;
use Deepwell\Data\Tests\Fakes\Enums\DummyBackedEnum;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
class CurrentPassword extends StringValidationAttribute
{
    public function __construct(protected null|string|DummyBackedEnum|RouteParameterReference $guard = null)
    {
    }

    public static function keyword(): string
    {
        return 'current_password';
    }

    public function parameters(): array
    {
        return [$this->guard];
    }
}
