<?php

namespace Deepwell\Data\Support\Lazy;

use Closure;
use Deepwell\Data\Lazy;

class ConditionalLazy extends Lazy
{
    protected function __construct(
        protected Closure $condition,
        protected Closure $value,
    ) {
    }

    public function resolve(): mixed
    {
        return ($this->value)();
    }

    public function shouldBeIncluded(): bool
    {
        return (bool) ($this->condition)();
    }
}
