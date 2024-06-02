<?php

namespace Deepwell\Data\Attributes\Validation;

use Attribute;
use Deepwell\Data\Support\Validation\References\RouteParameterReference;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
class Decimal extends StringValidationAttribute
{
    public function __construct(protected int|RouteParameterReference $min, protected int|null|RouteParameterReference $max = null)
    {
    }

    public static function keyword(): string
    {
        return 'decimal';
    }

    public function parameters(): array
    {
        return [$this->min, $this->max];
    }
}
