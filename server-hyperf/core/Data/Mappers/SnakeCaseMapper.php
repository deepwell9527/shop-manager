<?php

namespace Deepwell\Data\Mappers;

use Hyperf\Stringable\Str;

class SnakeCaseMapper implements NameMapper
{
    public function map(int|string $name): string|int
    {
        return Str::snake($name);
    }
}
