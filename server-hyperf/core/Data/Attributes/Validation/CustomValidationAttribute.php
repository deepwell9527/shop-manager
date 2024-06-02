<?php

namespace Deepwell\Data\Attributes\Validation;

use Deepwell\Data\Support\Validation\ValidationPath;
use Deepwell\Data\Support\Validation\ValidationRule;

abstract class CustomValidationAttribute extends ValidationRule
{
    /**
     * @return array<object|string>|object|string
     */
    abstract public function getRules(ValidationPath $path): array|object|string;
}
