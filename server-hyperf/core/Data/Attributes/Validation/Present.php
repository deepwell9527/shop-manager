<?php

namespace Deepwell\Data\Attributes\Validation;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
class Present extends StringValidationAttribute
{
    public static function keyword(): string
    {
        return 'present';
    }

    public function parameters(): array
    {
        return [];
    }
}
