<?php

namespace Deepwell\Data\Attributes\Validation;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
class Uppercase extends StringValidationAttribute
{
    public static function keyword(): string
    {
        return 'uppercase';
    }

    public function parameters(): array
    {
        return [];
    }
}
