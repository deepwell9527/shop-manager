<?php

namespace Deepwell\Data\Mappers;

interface NameMapper
{
    public function map(string|int $name): string|int;
}
