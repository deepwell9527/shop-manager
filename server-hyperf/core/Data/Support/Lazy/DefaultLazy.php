<?php

namespace Deepwell\Data\Support\Lazy;

use Closure;
use Deepwell\Data\Lazy;

class DefaultLazy extends Lazy
{
    protected function __construct(
        protected Closure $value
    ) {
    }

    public function resolve(): mixed
    {
        return ($this->value)();
    }
}
