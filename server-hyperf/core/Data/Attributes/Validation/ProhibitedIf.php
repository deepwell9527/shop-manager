<?php

namespace Deepwell\Data\Attributes\Validation;

use Attribute;
use BackedEnum;
use Illuminate\Support\Arr;
use Deepwell\Data\Support\Validation\References\FieldReference;
use Deepwell\Data\Support\Validation\References\RouteParameterReference;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
class ProhibitedIf extends StringValidationAttribute
{
    protected FieldReference $field;

    protected string|array $values;

    public function __construct(
        string|FieldReference $field,
        array | string | BackedEnum | RouteParameterReference ...$values
    ) {
        $this->field = $this->parseFieldReference($field);
        $this->values = Arr::flatten($values);
    }

    public static function keyword(): string
    {
        return 'prohibited_if';
    }

    public function parameters(): array
    {
        return [
            $this->field,
            $this->values,
        ];
    }
}
