<?php

namespace Deepwell\Data\Support;

use Deepwell\Data\Resolvers\DataCollectableFromSomethingResolver;
use Deepwell\Data\Resolvers\DataFromSomethingResolver;
use Deepwell\Data\Resolvers\DataValidatorResolver;
use Deepwell\Data\Resolvers\DecoupledPartialResolver;
use Deepwell\Data\Resolvers\RequestQueryStringPartialsResolver;
use Deepwell\Data\Resolvers\TransformedDataCollectableResolver;
use Deepwell\Data\Resolvers\TransformedDataResolver;
use Deepwell\Data\Resolvers\ValidatedPayloadResolver;
use Deepwell\Data\Support\Factories\DataClassFactory;

class DataContainer
{
    protected static self $instance;

    protected ?TransformedDataResolver $transformedDataResolver = null;

    protected ?TransformedDataCollectableResolver $transformedDataCollectableResolver = null;

    protected ?RequestQueryStringPartialsResolver $requestQueryStringPartialsResolver = null;

    protected ?DataFromSomethingResolver $dataFromSomethingResolver = null;

    protected ?DataCollectableFromSomethingResolver $dataCollectableFromSomethingResolver = null;

    protected ?DataValidatorResolver $dataValidatorResolver = null;

    protected ?ValidatedPayloadResolver $validatedPayloadResolver = null;

    protected ?DataClassFactory $dataClassFactory = null;

    protected ?DecoupledPartialResolver $decoupledPartialResolver = null;

    private function __construct()
    {
    }

    public static function get(): DataContainer
    {
        if (! isset(static::$instance)) {
            static::$instance = new self();
        }

        return static::$instance;
    }

    public function transformedDataResolver(): TransformedDataResolver
    {
        return $this->transformedDataResolver ??= container()->get(TransformedDataResolver::class);
    }

    public function transformedDataCollectableResolver(): TransformedDataCollectableResolver
    {
        return $this->transformedDataCollectableResolver ??= container()->get(TransformedDataCollectableResolver::class);
    }

    public function requestQueryStringPartialsResolver(): RequestQueryStringPartialsResolver
    {
        return $this->requestQueryStringPartialsResolver ??= container()->get(RequestQueryStringPartialsResolver::class);
    }

    public function dataFromSomethingResolver(): DataFromSomethingResolver
    {
        return $this->dataFromSomethingResolver ??= container()->get(DataFromSomethingResolver::class);
    }

    public function dataValidatorResolver(): DataValidatorResolver
    {
        return $this->dataValidatorResolver ??= container()->get(DataValidatorResolver::class);
    }

    public function validatedPayloadResolver(): ValidatedPayloadResolver
    {
        return $this->validatedPayloadResolver ??= container()->get(ValidatedPayloadResolver::class);
    }

    public function dataCollectableFromSomethingResolver(): DataCollectableFromSomethingResolver
    {
        return $this->dataCollectableFromSomethingResolver ??= container()->get(DataCollectableFromSomethingResolver::class);
    }

    public function dataClassFactory(): DataClassFactory
    {
        return $this->dataClassFactory ??= container()->get(DataClassFactory::class);
    }

    public function decoupledPartialResolver(): DecoupledPartialResolver
    {
        return $this->decoupledPartialResolver ??= container()->get(DecoupledPartialResolver::class);
    }

    public function reset()
    {
        $this->transformedDataResolver = null;
        $this->transformedDataCollectableResolver = null;
        $this->requestQueryStringPartialsResolver = null;
        $this->dataFromSomethingResolver = null;
        $this->dataCollectableFromSomethingResolver = null;
        $this->dataClassFactory = null;
        $this->decoupledPartialResolver = null;
    }
}
