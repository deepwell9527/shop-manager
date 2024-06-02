<?php

namespace Deepwell\Data\Support\Validation;

use BackedEnum;
use DateTimeInterface;
use Deepwell\Data\Attributes\Validation\CustomValidationAttribute;
use Deepwell\Data\Attributes\Validation\ObjectValidationAttribute;
use Deepwell\Data\Attributes\Validation\Rule;
use Deepwell\Data\Attributes\Validation\StringValidationAttribute;
use Deepwell\Data\Support\Validation\References\FieldReference;
use Deepwell\Data\Support\Validation\References\RouteParameterReference;
use Hyperf\Collection\Arr;
use Hyperf\Stringable\Str;
use function Hyperf\Collection\collect;

class RuleDenormalizer
{
    /** @return array<string|object|Rule> */
    public function execute(mixed $rule, ValidationPath $path): array
    {
        if (is_string($rule)) {
            return Str::contains($rule, 'regex:') ? [$rule] : explode('|', $rule);
        }

        if (is_array($rule)) {
            return Arr::flatten(array_map(
                fn(mixed $rule) => $this->execute($rule, $path),
                $rule
            ));
        }

        if ($rule instanceof StringValidationAttribute) {
            return $this->normalizeStringValidationAttribute($rule, $path);
        }

        if ($rule instanceof ObjectValidationAttribute) {
            return [$rule->getRule($path)];
        }

        if ($rule instanceof CustomValidationAttribute) {
            return Arr::wrap($rule->getRules($path));
        }

        if ($rule instanceof Rule) {
            return $this->execute($rule->get(), $path);
        }

        return [$rule];
    }

    protected function normalizeStringValidationAttribute(
        StringValidationAttribute $rule,
        ValidationPath            $path
    ): array
    {
        $parameters = collect($rule->parameters())
            ->map(fn(mixed $value) => $this->normalizeRuleParameter($value, $path))
            ->reject(fn(mixed $value) => $value === null);


        if ($parameters->isEmpty()) {
            return [$rule->keyword()];
        }

        $parameters = $parameters->map(
            fn(mixed $value, int|string $key) => is_string($key) ? "{$key}={$value}" : $value
        );

        return ["{$rule->keyword()}:{$parameters->implode(',')}"];
    }

    protected function normalizeRuleParameter(
        mixed          $parameter,
        ValidationPath $path
    ): ?string
    {
        if ($parameter === null) {
            return null;
        }

        if (is_string($parameter) || is_numeric($parameter)) {
            return (string)$parameter;
        }

        if (is_bool($parameter)) {
            return $parameter ? 'true' : 'false';
        }

        if (is_array($parameter) && count($parameter) === 0) {
            return null;
        }

        if (is_array($parameter)) {
            $subParameters = array_map(
                fn(mixed $subParameter) => $this->normalizeRuleParameter($subParameter, $path),
                $parameter
            );

            return implode(',', $subParameters);
        }

        if ($parameter instanceof DateTimeInterface) {
            return $parameter->format(DATE_ATOM);
        }

        if ($parameter instanceof BackedEnum) {
            return $parameter->value;
        }

        if ($parameter instanceof FieldReference) {
            return $parameter->getValue($path);
        }

        if ($parameter instanceof RouteParameterReference) {
            return $this->normalizeRuleParameter($parameter->getValue(), $path);
        }

        return (string)$parameter;
    }
}
