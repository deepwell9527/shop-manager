<?php

namespace Deepwell\Data\Contracts;

interface EmptyData
{
    public static function empty(array $extra = []): array;
}
