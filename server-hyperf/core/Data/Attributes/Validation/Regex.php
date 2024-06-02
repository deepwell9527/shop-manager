<?php

namespace Deepwell\Data\Attributes\Validation;

use Attribute;
use Deepwell\Data\Support\Validation\References\RouteParameterReference;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
class Regex extends StringValidationAttribute
{
    public function __construct(protected string|RouteParameterReference $pattern)
    {
    }

    public static function keyword(): string
    {
        return 'regex';
    }

    public function parameters(): array
    {
        return [
            $this->pattern,
        ];
    }
}
