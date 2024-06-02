<?php

namespace Deepwell\Data\Contracts;

use Deepwell\Data\Support\Wrapping\Wrap;

interface WrappableData extends ContextableData
{
    public function withoutWrapping();

    public function wrap(string $key);

    public function getWrap(): Wrap;
}
