<?php

namespace Deepwell\Data\Concerns;

use Deepwell\Data\Resolvers\EmptyDataResolver;

trait EmptyData
{
    public static function empty(array $extra = []): array
    {
        return container()->get(EmptyDataResolver::class)->execute(static::class, $extra);
    }
}
