<?php

namespace Deepwell\Data\Attributes\Validation;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
class Json extends StringValidationAttribute
{
    public static function keyword(): string
    {
        return 'json';
    }

    public function parameters(): array
    {
        return [];
    }
}
