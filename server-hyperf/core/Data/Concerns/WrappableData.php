<?php

namespace Deepwell\Data\Concerns;

use Deepwell\Data\Support\Wrapping\Wrap;
use Deepwell\Data\Support\Wrapping\WrapType;

trait WrappableData
{
    public function withoutWrapping(): static
    {
        $this->getDataContext()->wrap = new Wrap(WrapType::Disabled);

        return $this;
    }

    public function wrap(string $key): static
    {
        $this->getDataContext()->wrap = new Wrap(WrapType::Defined, $key);

        return $this;
    }

    public function getWrap(): Wrap
    {
        return $this->getDataContext()->wrap ?? new Wrap(WrapType::UseGlobal);
    }
}
