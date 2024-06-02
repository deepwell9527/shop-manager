<?php

namespace Deepwell\Data\Exceptions;

use Exception;
use Deepwell\Data\Attributes\FromRouteParameterProperty;
use Deepwell\Data\Support\DataProperty;

class CannotFillFromRouteParameterPropertyUsingScalarValue extends Exception
{
    public static function create(DataProperty $property, FromRouteParameterProperty $attribute, mixed $value): self
    {
        return new self("Attribute FromRouteParameterProperty cannot be used with scalar route parameters. {$property->className}::{$property->name} is configured to be filled from {$attribute->routeParameter}::{$attribute->property}, but the route parameter has a scalar value ({$value}).");
    }
}
