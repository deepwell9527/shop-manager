<?php

namespace Deepwell\Data\Attributes\Validation;

use Attribute;
use Deepwell\Data\Support\Validation\References\RouteParameterReference;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
class DigitsBetween extends StringValidationAttribute
{
    public function __construct(protected int|RouteParameterReference $min, protected int|RouteParameterReference $max)
    {
    }

    public static function keyword(): string
    {
        return 'digits_between';
    }

    public function parameters(): array
    {
        return [$this->min, $this->max];
    }
}
