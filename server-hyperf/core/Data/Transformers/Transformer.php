<?php

namespace Deepwell\Data\Transformers;

use Deepwell\Data\Support\DataProperty;
use Deepwell\Data\Support\Transformation\TransformationContext;

interface Transformer
{
    public function transform(DataProperty $property, mixed $value, TransformationContext $context): mixed;
}
