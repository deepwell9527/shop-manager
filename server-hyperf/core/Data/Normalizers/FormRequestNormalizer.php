<?php

namespace Deepwell\Data\Normalizers;

use Hyperf\Validation\Request\FormRequest;

class FormRequestNormalizer implements Normalizer
{
    public function normalize(mixed $value): ?array
    {
        if (! $value instanceof FormRequest) {
            return null;
        }

        return $value->validated();
    }
}
