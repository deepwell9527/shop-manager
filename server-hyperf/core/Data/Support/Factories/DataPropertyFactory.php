<?php

namespace Deepwell\Data\Support\Factories;

use ReflectionAttribute;
use ReflectionClass;
use ReflectionProperty;
use Deepwell\Data\Attributes\Computed;
use Deepwell\Data\Attributes\GetsCast;
use Deepwell\Data\Attributes\Hidden;
use Deepwell\Data\Attributes\WithCastAndTransformer;
use Deepwell\Data\Attributes\WithoutValidation;
use Deepwell\Data\Attributes\WithTransformer;
use Deepwell\Data\Mappers\NameMapper;
use Deepwell\Data\Resolvers\NameMappersResolver;
use Deepwell\Data\Support\Annotations\DataIterableAnnotation;
use Deepwell\Data\Support\DataProperty;
use function Hyperf\Collection\collect;

class DataPropertyFactory
{
    public function __construct(
        protected DataTypeFactory $typeFactory,
    ) {
    }

    public function build(
        ReflectionProperty $reflectionProperty,
        ReflectionClass $reflectionClass,
        bool $hasDefaultValue = false,
        mixed $defaultValue = null,
        ?NameMapper $classInputNameMapper = null,
        ?NameMapper $classOutputNameMapper = null,
        ?DataIterableAnnotation $classDefinedDataIterableAnnotation = null,
    ): DataProperty {
        $attributes = collect($reflectionProperty->getAttributes())
            ->filter(fn (ReflectionAttribute $reflectionAttribute) => class_exists($reflectionAttribute->getName()))
            ->map(fn (ReflectionAttribute $reflectionAttribute) => $reflectionAttribute->newInstance());

        $mappers = NameMappersResolver::create()->execute($attributes);

        $inputMappedName = match (true) {
            $mappers['inputNameMapper'] !== null => $mappers['inputNameMapper']->map($reflectionProperty->name),
            $classInputNameMapper !== null => $classInputNameMapper->map($reflectionProperty->name),
            default => null,
        };

        $outputMappedName = match (true) {
            $mappers['outputNameMapper'] !== null => $mappers['outputNameMapper']->map($reflectionProperty->name),
            $classOutputNameMapper !== null => $classOutputNameMapper->map($reflectionProperty->name),
            default => null,
        };

        $computed = $attributes->contains(
            fn (object $attribute) => $attribute instanceof Computed
        );

        $hidden = $attributes->contains(
            fn (object $attribute) => $attribute instanceof Hidden
        );

        $validate = ! $attributes->contains(
            fn (object $attribute) => $attribute instanceof WithoutValidation
        ) && ! $computed;

        return new DataProperty(
            name: $reflectionProperty->name,
            className: $reflectionProperty->class,
            type: $this->typeFactory->buildProperty(
                $reflectionProperty->getType(),
                $reflectionClass,
                $reflectionProperty,
                $attributes,
                $classDefinedDataIterableAnnotation
            ),
            validate: $validate,
            computed: $computed,
            hidden: $hidden,
            isPromoted: $reflectionProperty->isPromoted(),
            isReadonly: $reflectionProperty->isReadOnly(),
            hasDefaultValue: $reflectionProperty->isPromoted() ? $hasDefaultValue : $reflectionProperty->hasDefaultValue(),
            defaultValue: $reflectionProperty->isPromoted() ? $defaultValue : $reflectionProperty->getDefaultValue(),
            cast: $attributes->first(fn (object $attribute) => $attribute instanceof GetsCast)?->get(),
            transformer: $attributes->first(fn (object $attribute) => $attribute instanceof WithTransformer || $attribute instanceof WithCastAndTransformer)?->get(),
            inputMappedName: $inputMappedName,
            outputMappedName: $outputMappedName,
            attributes: $attributes,
        );
    }
}
