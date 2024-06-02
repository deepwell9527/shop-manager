<?php

namespace Deepwell\Data\Attributes\Validation;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
class IP extends StringValidationAttribute
{
    public static function keyword(): string
    {
        return 'ip';
    }

    public function parameters(): array
    {
        return [];
    }
}
