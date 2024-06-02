<?php

namespace Deepwell\Data\Attributes\Validation;

use Attribute;
use Deepwell\Data\Exceptions\CannotBuildValidationRule;
use Deepwell\Data\Support\Validation\References\RouteParameterReference;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
class Distinct extends StringValidationAttribute
{
    public const Strict = 'strict';
    public const IgnoreCase = 'ignore_case';

    public function __construct(protected null|string|RouteParameterReference $mode = null)
    {
    }

    public static function keyword(): string
    {
        return 'distinct';
    }

    public function parameters(): array
    {
        if ($this->mode === null) {
            return [];
        }

        if (! in_array($this->mode, [self::IgnoreCase, self::Strict])) {
            throw CannotBuildValidationRule::create('Distinct mode should be ignore_case or strict.');
        }

        return [$this->mode];
    }
}
