<?php

namespace Deepwell\Data\Resolvers;

use Deepwell\Data\Attributes\MapInputName;
use Deepwell\Data\Attributes\MapName;
use Deepwell\Data\Attributes\MapOutputName;
use Deepwell\Data\Mappers\NameMapper;
use Deepwell\Data\Mappers\ProvidedNameMapper;
use Hyperf\Collection\Collection;

class NameMappersResolver
{
    public function __construct(protected array $ignoredMappers = [])
    {
    }

    public static function create(array $ignoredMappers = []): self
    {
        return new self($ignoredMappers);
    }

    public function execute(
        Collection $attributes
    ): array
    {
        return [
            'inputNameMapper' => $this->resolveInputNameMapper($attributes),
            'outputNameMapper' => $this->resolveOutputNameMapper($attributes),
        ];
    }

    protected function resolveInputNameMapper(
        Collection $attributes
    ): ?NameMapper
    {
        /** @var MapInputName|MapName|null $mapper */
        $mapper = $attributes->first(fn(object $attribute) => $attribute instanceof MapInputName)
            ?? $attributes->first(fn(object $attribute) => $attribute instanceof MapName);

        if ($mapper) {
            return $this->resolveMapper($mapper->input);
        }

        return null;
    }

    protected function resolveMapper(string|int|NameMapper $value): ?NameMapper
    {
        $mapper = $this->resolveMapperClass($value);

        foreach ($this->ignoredMappers as $ignoredMapper) {
            if ($mapper instanceof $ignoredMapper) {
                return null;
            }
        }

        return $mapper;
    }

    protected function resolveMapperClass(int|string|NameMapper $value): NameMapper
    {
        if (is_int($value)) {
            return new ProvidedNameMapper($value);
        }

        if ($value instanceof NameMapper) {
            return $value;
        }

        if (is_a($value, NameMapper::class, true)) {
            return \Hyperf\Support\make($value);
        }

        return new ProvidedNameMapper($value);
    }

    protected function resolveOutputNameMapper(
        Collection $attributes
    ): ?NameMapper
    {
        /** @var MapOutputName|MapName|null $mapper */
        $mapper = $attributes->first(fn(object $attribute) => $attribute instanceof MapOutputName)
            ?? $attributes->first(fn(object $attribute) => $attribute instanceof MapName);

        if ($mapper) {
            return $this->resolveMapper($mapper->output);
        }

        return null;
    }
}
