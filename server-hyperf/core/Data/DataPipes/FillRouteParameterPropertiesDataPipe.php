<?php

namespace Deepwell\Data\DataPipes;

use Deepwell\Data\Attributes\FromRouteParameter;
use Deepwell\Data\Attributes\FromRouteParameterProperty;
use Deepwell\Data\Exceptions\CannotFillFromRouteParameterPropertyUsingScalarValue;
use Deepwell\Data\Support\Creation\CreationContext;
use Deepwell\Data\Support\DataClass;
use Deepwell\Data\Support\DataProperty;
use Hyperf\HttpServer\Contract\RequestInterface;
use function Hyperf\Collection\data_get;

class FillRouteParameterPropertiesDataPipe implements DataPipe
{
    public function handle(
        mixed           $payload,
        DataClass       $class,
        array           $properties,
        CreationContext $creationContext
    ): array
    {
        if (!$payload instanceof RequestInterface) {
            return $properties;
        }

        foreach ($class->properties as $dataProperty) {
            $attribute = $dataProperty->attributes->first(
                fn(object $attribute) => $attribute instanceof FromRouteParameter || $attribute instanceof FromRouteParameterProperty
            );

            if ($attribute === null) {
                continue;
            }

            if (!$attribute->replaceWhenPresentInBody && array_key_exists($dataProperty->name, $properties)) {
                continue;
            }

            $parameter = $payload->route($attribute->routeParameter);

            if ($parameter === null) {
                continue;
            }

            $properties[$dataProperty->name] = $this->resolveValue($dataProperty, $attribute, $parameter);
        }

        return $properties;
    }

    protected function resolveValue(
        DataProperty                                  $dataProperty,
        FromRouteParameter|FromRouteParameterProperty $attribute,
        mixed                                         $parameter,
    ): mixed
    {
        if ($attribute instanceof FromRouteParameter) {
            return $parameter;
        }

        if (is_scalar($parameter)) {
            throw CannotFillFromRouteParameterPropertyUsingScalarValue::create($dataProperty, $attribute, $parameter);
        }

        return data_get($parameter, $attribute->property ?? $dataProperty->name);
    }
}
