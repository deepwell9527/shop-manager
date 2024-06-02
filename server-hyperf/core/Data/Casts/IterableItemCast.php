<?php

namespace Deepwell\Data\Casts;

use Deepwell\Data\Support\Creation\CreationContext;
use Deepwell\Data\Support\DataProperty;

interface IterableItemCast
{
    public function castIterableItem(DataProperty $property, mixed $value, array $properties, CreationContext $context): mixed;
}
