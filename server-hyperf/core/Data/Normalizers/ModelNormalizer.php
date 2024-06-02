<?php

namespace Deepwell\Data\Normalizers;


use Deepwell\Data\Normalizers\Normalized\Normalized;
use Deepwell\Data\Normalizers\Normalized\NormalizedModel;
use Hyperf\Database\Model\Model;

class ModelNormalizer implements Normalizer
{
    public function normalize(mixed $value): null|array|Normalized
    {
        if (! $value instanceof Model) {
            return null;
        }

        return new NormalizedModel($value);
    }
}
