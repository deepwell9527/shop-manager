<?php

namespace Deepwell\Data\Attributes\Validation;

use Attribute;
use Deepwell\Data\Support\Validation\References\RouteParameterReference;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
class MinDigits extends StringValidationAttribute
{
    public function __construct(protected int|RouteParameterReference $value)
    {
    }

    public static function keyword(): string
    {
        return 'min_digits';
    }

    public function parameters(): array
    {
        return [$this->value];
    }
}
