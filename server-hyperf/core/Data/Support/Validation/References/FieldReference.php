<?php

namespace Deepwell\Data\Support\Validation\References;

use Deepwell\Data\Support\Validation\ValidationPath;

class FieldReference
{
    public function __construct(
        public readonly string $name,
        public readonly bool $fromRoot = false,
    ) {
    }

    public function getValue(ValidationPath $path): string
    {
        return $this->fromRoot
            ? $this->name
            : $path->property($this->name)->get();
    }
}
