<?php

namespace Deepwell\Data\Attributes\Validation;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
class IPv6 extends StringValidationAttribute
{
    public static function keyword(): string
    {
        return 'ipv6';
    }

    public function parameters(): array
    {
        return [];
    }
}
