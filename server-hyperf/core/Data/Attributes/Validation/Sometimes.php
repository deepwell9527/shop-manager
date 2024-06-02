<?php

namespace Deepwell\Data\Attributes\Validation;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
class Sometimes extends StringValidationAttribute
{
    public static function keyword(): string
    {
        return 'sometimes';
    }

    public function parameters(): array
    {
        return [];
    }
}
