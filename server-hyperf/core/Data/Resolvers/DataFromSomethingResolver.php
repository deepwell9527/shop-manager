<?php

namespace Deepwell\Data\Resolvers;

use Hyperf\HttpServer\Contract\RequestInterface;
use Deepwell\Data\Contracts\BaseData;
use Deepwell\Data\Enums\CustomCreationMethodType;
use Deepwell\Data\Optional;
use Deepwell\Data\Support\Creation\CreationContext;
use Deepwell\Data\Support\DataConfig;


class DataFromSomethingResolver
{
    public function __construct(
        protected DataConfig $dataConfig,
        protected DataFromArrayResolver $dataFromArrayResolver,
    ) {
    }

    public function execute(
        string $class,
        CreationContext $creationContext,
        mixed ...$payloads
    ): BaseData {
        if ($data = $this->createFromCustomCreationMethod($class, $creationContext, $payloads)) {
            return $data;
        }

        $pipeline = $this->dataConfig->getResolvedDataPipeline($class);

        $payloadCount = count($payloads);

        if ($payloadCount === 0 || $payloadCount === 1) {
            return $this->dataFromArrayResolver->execute(
                $class,
                $pipeline->execute($payloads[0] ?? [], $creationContext)
            );
        }

        $properties = [];

        foreach ($payloads as $payload) {
            foreach ($pipeline->execute($payload, $creationContext) as $key => $value) {
                if (array_key_exists($key, $properties) && ($value === null || $value instanceof Optional)) {
                    continue;
                }

                $properties[$key] = $value;
            }
        }

        return $this->dataFromArrayResolver->execute($class, $properties);
    }

    protected function createFromCustomCreationMethod(
        string $class,
        CreationContext $creationContext,
        array $payloads
    ): ?BaseData {
        if ($creationContext->disableMagicalCreation) {
            return null;
        }

        $customCreationMethods = $this->dataConfig
            ->getDataClass($class)
            ->methods;

        $method = null;

        foreach ($customCreationMethods as $customCreationMethod) {
            if ($customCreationMethod->customCreationMethodType !== CustomCreationMethodType::Object) {
                continue;
            }

            if (
                $creationContext->ignoredMagicalMethods !== null
                && in_array($customCreationMethod->name, $creationContext->ignoredMagicalMethods)
            ) {
                continue;
            }

            if ($customCreationMethod->accepts(...$payloads)) {
                $method = $customCreationMethod;

                break;
            }
        }

        if ($method === null) {
            return null;
        }

        $pipeline = $this->dataConfig->getResolvedDataPipeline($class);
        foreach ($payloads as $payload) {
            if ($payload instanceof RequestInterface) {
                // Solely for the purpose of validation
                $pipeline->execute($payload, $creationContext);
            }
        }

        foreach ($method->parameters as $index => $parameter) {
            if ($parameter->type->type->isCreationContext()) {
                $payloads[$index] = $creationContext;
            }
        }

        $methodName = $method->name;

        return $class::$methodName(...$payloads);
    }
}
