<?php

namespace Deepwell\Data\Attributes\Validation;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
class ActiveUrl extends StringValidationAttribute
{
    public static function keyword(): string
    {
        return 'active_url';
    }

    public function parameters(): array
    {
        return [];
    }
}
