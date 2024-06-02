<?php

namespace Deepwell\Data\Support\Validation\References;

use Deepwell\Data\Exceptions\CannotResolveRouteParameterReference;
use Hyperf\HttpServer\Contract\RequestInterface;
use Stringable;
use function Hyperf\Collection\data_get;

class RouteParameterReference implements Stringable
{
    public function __construct(
        public readonly string $routeParameter,
        public readonly ?string $property = null,
        public readonly bool $nullable = false,
    ) {
    }

    public function getValue(): ?string
    {
        $request = container()->get(RequestInterface::class);
        $parameter = $request->route($this->routeParameter);

        if ($parameter === null && $this->nullable === false) {
            throw CannotResolveRouteParameterReference::parameterNotFound($this->routeParameter, $this->property);
        }

        if ($parameter === null) {
            return null;
        }

        if ($this->property === null) {
            return $parameter;
        }

        $value = data_get($parameter, $this->property);

        if ($value === null) {
            throw CannotResolveRouteParameterReference::propertyOnParameterNotFound($this->routeParameter, $this->property);
        }

        return $value;
    }

    public function __toString(): string
    {
        return $this->getValue();
    }
}
