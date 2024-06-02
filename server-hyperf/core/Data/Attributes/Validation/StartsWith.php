<?php

namespace Deepwell\Data\Attributes\Validation;

use Attribute;
use Illuminate\Support\Arr;
use Deepwell\Data\Support\Validation\References\RouteParameterReference;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
class StartsWith extends StringValidationAttribute
{
    protected string|array $values;

    public function __construct(string | array | RouteParameterReference ...$values)
    {
        $this->values = Arr::flatten($values);
    }

    public static function keyword(): string
    {
        return 'starts_with';
    }

    public function parameters(): array
    {
        return [$this->values];
    }
}
