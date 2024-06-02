<?php

namespace Deepwell\Data\Normalizers;

use Hyperf\Contract\Arrayable;

class ArrayableNormalizer implements Normalizer
{
    public function normalize(mixed $value): ?array
    {
        if (! $value instanceof Arrayable) {
            return null;
        }

        return $value->toArray();
    }
}
