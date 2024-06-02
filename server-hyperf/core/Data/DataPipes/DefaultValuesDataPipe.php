<?php

namespace Deepwell\Data\DataPipes;

use Deepwell\Data\Optional;
use Deepwell\Data\Support\Creation\CreationContext;
use Deepwell\Data\Support\DataClass;

class DefaultValuesDataPipe implements DataPipe
{
    public function handle(
        mixed $payload,
        DataClass $class,
        array $properties,
        CreationContext $creationContext
    ): array {
        foreach ($class->properties as $name => $property) {
            if(array_key_exists($name, $properties)) {
                continue;
            }

            if ($property->hasDefaultValue) {
                $properties[$name] = $property->defaultValue;

                continue;
            }

            if ($property->type->isOptional) {
                $properties[$name] = Optional::create();

                continue;
            }

            if ($property->type->isNullable) {
                $properties[$name] = null;
            }
        }

        return $properties;
    }
}
