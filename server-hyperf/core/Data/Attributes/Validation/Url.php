<?php

namespace Deepwell\Data\Attributes\Validation;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
class Url extends StringValidationAttribute
{
    public static function keyword(): string
    {
        return 'url';
    }

    public function parameters(): array
    {
        return [];
    }
}
