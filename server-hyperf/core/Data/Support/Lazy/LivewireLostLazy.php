<?php

namespace Deepwell\Data\Support\Lazy;

use Exception;
use Deepwell\Data\Lazy;

class LivewireLostLazy extends Lazy
{
    public function __construct(
        public string $dataClass,
        public string $propertyName
    ) {
    }

    public function resolve(): mixed
    {
        return throw new Exception("Lazy property `{$this->dataClass}::{$this->propertyName}` was lost when the data object was transformed to be used by Livewire. You can include the property and then the correct value will be set when creating the data object from Livewire again.");
    }
}
