<?php

namespace Deepwell\Data\Exceptions;

use Exception;
use Deepwell\Data\Support\DataClass;
use Deepwell\Data\Support\DataParameter;
use Deepwell\Data\Support\DataProperty;
use Throwable;
use function Hyperf\Collection\collect;

class CannotCreateData extends Exception
{
    public static function noNormalizerFound(string $dataClass, mixed $value): self
    {
        $type = gettype($value);

        if ($type === 'object') {
            $type = $value::class;
        }

        return new self("Could not create a `{$dataClass}` object from value with type `{$type}`, no normalizer was found");
    }

    public static function constructorMissingParameters(
        DataClass $dataClass,
        array $parameters,
        Throwable $previous,
    ): self {
        $parameters = collect($parameters);

        $message = "Could not create `{$dataClass->name}`: the constructor requires {$dataClass->constructorMethod->parameters->count()} parameters, {$parameters->count()} given.";


        if ($parameters->isNotEmpty()) {
            $message .= " Parameters given: {$parameters->keys()->implode(', ')}.";
        }

        $message .= " Parameters missing: {$dataClass
                ->constructorMethod
                ->parameters
                ->reject(fn (DataProperty|DataParameter $parameter) => $parameters->has($parameter->name))
                ->map(fn (DataProperty|DataParameter $parameter) => $parameter->name)
                ->implode(', ')}.";

        return new self($message, previous: $previous);
    }
}
