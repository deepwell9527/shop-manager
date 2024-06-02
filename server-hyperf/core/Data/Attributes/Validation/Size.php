<?php

namespace Deepwell\Data\Attributes\Validation;

use Attribute;
use Deepwell\Data\Support\Validation\References\RouteParameterReference;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
class Size extends StringValidationAttribute
{
    public function __construct(protected int|RouteParameterReference $size)
    {
    }

    public static function keyword(): string
    {
        return 'size';
    }

    public function parameters(): array
    {
        return [$this->size];
    }
}
