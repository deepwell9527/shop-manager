<?php

namespace Deepwell\Data\DataPipes;

use Deepwell\Data\Support\Creation\CreationContext;
use Deepwell\Data\Support\DataClass;
use Hyperf\HttpServer\Contract\RequestInterface;

class AuthorizedDataPipe implements DataPipe
{
    public function handle(
        mixed           $payload,
        DataClass       $class,
        array           $properties,
        CreationContext $creationContext
    ): array
    {
        if (!$payload instanceof RequestInterface) {
            return $properties;
        }

        $this->ensureRequestIsAuthorized($class->name);

        return $properties;
    }

    protected function ensureRequestIsAuthorized(string $class): void
    {

    }
}
