<?php

namespace Deepwell\Data\Attributes\Validation;

use Deepwell\Data\Support\Validation\References\RouteParameterReference;
use Deepwell\Data\Support\Validation\ValidationPath;

abstract class ObjectValidationAttribute extends ValidationAttribute
{
    abstract public function getRule(ValidationPath $path): object|string;

    protected function normalizePossibleRouteReferenceParameter(mixed $parameter): mixed
    {
        if ($parameter instanceof RouteParameterReference) {
            return $parameter->getValue();
        }

        return $parameter;
    }
}
