<?php

namespace Deepwell\Data\Normalizers\Normalized;

use Deepwell\Data\Support\DataProperty;

interface Normalized
{
    public function getProperty(string $name, DataProperty $dataProperty): mixed;
}
