<?php

namespace Deepwell\Data\Attributes\Validation;

use Attribute;
use DateTimeInterface;
use Deepwell\Data\Support\Validation\References\FieldReference;
use Deepwell\Data\Support\Validation\References\RouteParameterReference;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
class Before extends StringValidationAttribute
{
    public function __construct(protected string|DateTimeInterface|RouteParameterReference|FieldReference $date)
    {
    }

    public static function keyword(): string
    {
        return 'before';
    }

    public function parameters(): array
    {
        return [$this->date];
    }

    public static function create(string ...$parameters): static
    {
        return parent::create(
            self::parseDateValue($parameters[0]),
        );
    }
}
