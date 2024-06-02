<?php

namespace Deepwell\Data\Normalizers;


use Symfony\Contracts\HttpClient\ResponseInterface;

class ResponseNormalizer implements Normalizer
{
    public function normalize(mixed $value): ?array
    {
        if (!$value instanceof ResponseInterface) {
            return null;
        }

        return $value->toArray(false);
    }
}
