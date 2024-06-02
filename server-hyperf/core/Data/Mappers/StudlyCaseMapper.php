<?php

namespace Deepwell\Data\Mappers;

use Hyperf\Stringable\Str;

class StudlyCaseMapper implements NameMapper
{
    public function map(int|string $name): string|int
    {
        return Str::studly($name);
    }
}
