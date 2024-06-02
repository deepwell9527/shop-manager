<?php

namespace Deepwell\Data\DataPipes;

use Hyperf\HttpServer\Contract\RequestInterface;
use Deepwell\Data\Support\Creation\CreationContext;
use Deepwell\Data\Support\Creation\ValidationStrategy;
use Deepwell\Data\Support\DataClass;

class ValidatePropertiesDataPipe implements DataPipe
{
    public function handle(
        mixed $payload,
        DataClass $class,
        array $properties,
        CreationContext $creationContext
    ): array {
        if ($creationContext->validationStrategy === ValidationStrategy::Disabled
            || $creationContext->validationStrategy === ValidationStrategy::AlreadyRan
        ) {
            return $properties;
        }

        if ($creationContext->validationStrategy === ValidationStrategy::OnlyRequests && ! $payload instanceof RequestInterface) {
            return $properties;
        }

        ($class->name)::validate($properties);

        $creationContext->validationStrategy = ValidationStrategy::AlreadyRan;

        return $properties;
    }
}
