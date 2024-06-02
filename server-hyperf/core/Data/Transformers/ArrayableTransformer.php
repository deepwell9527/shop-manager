<?php

namespace Deepwell\Data\Transformers;

use Deepwell\Data\Support\DataProperty;
use Deepwell\Data\Support\Transformation\TransformationContext;

class ArrayableTransformer implements Transformer
{
    public function transform(DataProperty $property, mixed $value, TransformationContext $context): array
    {
        /** @var \Hyperf\Contract\Arrayable $value */
        return $value->toArray();
    }
}
