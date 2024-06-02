<?php

namespace Deepwell\Data\DataPipes;

use Deepwell\Data\Support\Creation\CreationContext;
use Deepwell\Data\Support\DataClass;

interface DataPipe
{
    /**
     * @param array<array-key, mixed> $properties
     *
     * @return array<array-key, mixed>
     */
    public function handle(mixed $payload, DataClass $class, array $properties, CreationContext $creationContext): array;
}
