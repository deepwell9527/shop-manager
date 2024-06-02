<?php

namespace Deepwell\Data\Support\Lazy;

use Closure;

class InertiaLazy extends ConditionalLazy
{
    public function __construct(
        Closure $value,
    ) {
        parent::__construct(fn () => true, $value);
    }

    public function resolve(): LazyProp
    {
        return new LazyProp($this->value);
    }
}
