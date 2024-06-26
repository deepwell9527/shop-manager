<?php

namespace Deepwell\Data;

use Closure;
use Deepwell\Data\Support\Lazy\ClosureLazy;
use Deepwell\Data\Support\Lazy\ConditionalLazy;
use Deepwell\Data\Support\Lazy\DefaultLazy;
use Deepwell\Data\Support\Lazy\InertiaLazy;
use Deepwell\Data\Support\Lazy\RelationalLazy;
use Hyperf\Database\Model\Model;
use Hyperf\Macroable\Macroable;

abstract class Lazy
{
    use Macroable;

    protected ?bool $defaultIncluded = null;

    public static function create(Closure $value): DefaultLazy
    {
        return new DefaultLazy($value);
    }

    public static function when(Closure $condition, Closure $value): ConditionalLazy
    {
        return new ConditionalLazy($condition, $value);
    }

    public static function whenLoaded(string $relation, Model $model, Closure $value): RelationalLazy
    {
        return new RelationalLazy($relation, $model, $value);
    }

    public static function inertia(Closure $value): InertiaLazy
    {
        return new InertiaLazy($value);
    }

    public static function closure(Closure $closure): ClosureLazy
    {
        return new ClosureLazy($closure);
    }

    abstract public function resolve(): mixed;

    public function defaultIncluded(bool $defaultIncluded = true): self
    {
        $this->defaultIncluded = $defaultIncluded;

        return $this;
    }

    public function isDefaultIncluded(): bool
    {
        return $this->defaultIncluded ?? false;
    }

    public function __get(string $name): mixed
    {
        return $this->resolve()->$name;
    }

    public function __call(string $method, array $parameters): mixed
    {
        return call_user_func_array([$this->resolve(), $method], $parameters);
    }
}
