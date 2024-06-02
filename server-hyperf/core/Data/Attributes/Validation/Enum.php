<?php

namespace Deepwell\Data\Attributes\Validation;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
class Enum extends StringValidationAttribute
{
    public function __construct(
        protected string $enum
    )
    {
    }

    public static function keyword(): string
    {
        return 'in';
    }

    public function parameters(): array
    {
        if (!enum_exists($this->enum)) {
            return [];
        }
        $p = [];
        foreach ($this->enum::cases() as $case) {
            $p[] = $case;
        }
        return $p;
    }
}
