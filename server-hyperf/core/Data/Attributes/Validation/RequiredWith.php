<?php

namespace Deepwell\Data\Attributes\Validation;

use Attribute;
use Illuminate\Support\Arr;
use Deepwell\Data\Support\Validation\References\FieldReference;
use Deepwell\Data\Support\Validation\RequiringRule;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
class RequiredWith extends StringValidationAttribute implements RequiringRule
{
    protected array $fields;

    public function __construct(array|string|FieldReference ...$fields)
    {
        foreach (Arr::flatten($fields) as $field) {
            $this->fields[] = $field instanceof FieldReference ? $field : new FieldReference($field);
        }
    }

    public static function keyword(): string
    {
        return 'required_with';
    }

    public function parameters(): array
    {
        return [
            $this->fields,
        ];
    }
}
