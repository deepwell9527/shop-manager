<?php

namespace Deepwell\Data\Normalizers;

use Hyperf\HttpServer\Contract\RequestInterface;

class RequestNormalizer implements Normalizer
{
    public function normalize(mixed $value): ?array
    {
        if (!$value instanceof RequestInterface) {
            return null;
        }

        return $value->all();
    }
}
