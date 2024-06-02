<?php

namespace Deepwell\Data\Mappers;


use Hyperf\Stringable\Str;

class CamelCaseMapper implements NameMapper
{
    public function map(int|string $name): string|int
    {
        return Str::camel($name);
    }
}
