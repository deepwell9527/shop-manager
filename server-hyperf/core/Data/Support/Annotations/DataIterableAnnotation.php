<?php

namespace Deepwell\Data\Support\Annotations;

class DataIterableAnnotation
{
    public function __construct(
        public string $type,
        public bool $isData,
        public string $keyType = 'array-key',
        public ?string $property = null,
    ) {
    }
}
