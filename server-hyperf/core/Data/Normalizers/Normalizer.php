<?php

namespace Deepwell\Data\Normalizers;

use Deepwell\Data\Normalizers\Normalized\Normalized;

interface Normalizer
{
    public function normalize(mixed $value): null|array|Normalized;
}
