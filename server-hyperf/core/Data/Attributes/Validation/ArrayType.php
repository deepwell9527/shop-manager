<?php

namespace Deepwell\Data\Attributes\Validation;

use Attribute;
use Deepwell\Data\Support\Validation\References\RouteParameterReference;
use Hyperf\Collection\Arr;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
class ArrayType extends StringValidationAttribute
{
    protected array $keys;

    public function __construct(array|string|RouteParameterReference ...$keys)
    {
        $this->keys = Arr::flatten($keys);
    }

    public static function keyword(): string
    {
        return 'array';
    }

    public function parameters(): array
    {
        return $this->keys;
    }
}
