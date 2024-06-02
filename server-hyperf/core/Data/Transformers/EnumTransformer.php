<?php

namespace Deepwell\Data\Transformers;

use Deepwell\Data\Support\DataProperty;
use Deepwell\Data\Support\Transformation\TransformationContext;

class EnumTransformer implements Transformer
{
    public function transform(DataProperty $property, mixed $value, TransformationContext $context): string|int
    {
        return $value->value;
    }
}
