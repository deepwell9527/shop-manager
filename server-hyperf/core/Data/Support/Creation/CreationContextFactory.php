<?php

namespace Deepwell\Data\Support\Creation;

use Deepwell\Data\Casts\Cast;
use Deepwell\Data\DataCollection;
use Deepwell\Data\PaginatedDataCollection;
use Deepwell\Data\Support\DataContainer;
use Hyperf\Collection\Collection;
use Hyperf\Contract\PaginatorInterface as PaginatorContract;
use Hyperf\Paginator\AbstractPaginator;
use function Hyperf\Config\config;

/**
 * @template TData
 */
class CreationContextFactory
{
    /**
     * @param class-string<TData> $dataClass
     */
    public function __construct(
        public string                 $dataClass,
        public ValidationStrategy     $validationStrategy,
        public bool                   $mapPropertyNames,
        public bool                   $disableMagicalCreation,
        public ?array                 $ignoredMagicalMethods,
        public ?GlobalCastsCollection $casts,
    )
    {
    }

    public static function createFromConfig(
        string $dataClass,
        ?array $config = null
    ): self
    {
        $config ??= config('data');

        return new self(
            dataClass: $dataClass,
            validationStrategy: ValidationStrategy::from($config['validation_strategy']),
            mapPropertyNames: true,
            disableMagicalCreation: false,
            ignoredMagicalMethods: null,
            casts: null,
        );
    }

    /**
     * @return TData
     */
    public function from(mixed ...$payloads)
    {
        return DataContainer::get()->dataFromSomethingResolver()->execute(
            $this->dataClass,
            $this->get(),
            ...$payloads
        );
    }

    public function get(): CreationContext
    {
        return new CreationContext(
            dataClass: $this->dataClass,
            mappedProperties: [],
            currentPath: [],
            validationStrategy: $this->validationStrategy,
            mapPropertyNames: $this->mapPropertyNames,
            disableMagicalCreation: $this->disableMagicalCreation,
            ignoredMagicalMethods: $this->ignoredMagicalMethods,
            casts: $this->casts,
        );
    }

    public static function createFromCreationContext(
        string          $dataClass,
        CreationContext $creationContext,
    ): self
    {
        return new self(
            dataClass: $dataClass,
            validationStrategy: $creationContext->validationStrategy,
            mapPropertyNames: $creationContext->mapPropertyNames,
            disableMagicalCreation: $creationContext->disableMagicalCreation,
            ignoredMagicalMethods: $creationContext->ignoredMagicalMethods,
            casts: $creationContext->casts,
        );
    }

    public function validationStrategy(ValidationStrategy $validationStrategy): self
    {
        $this->validationStrategy = $validationStrategy;

        return $this;
    }

    public function withoutValidation(): self
    {
        $this->validationStrategy = ValidationStrategy::Disabled;

        return $this;
    }

    public function onlyValidateRequests(): self
    {
        $this->validationStrategy = ValidationStrategy::OnlyRequests;

        return $this;
    }

    public function alwaysValidate(): self
    {
        $this->validationStrategy = ValidationStrategy::Always;

        return $this;
    }

    public function withPropertyNameMapping(bool $withPropertyNameMapping = true): self
    {
        $this->mapPropertyNames = $withPropertyNameMapping;

        return $this;
    }

    public function withoutPropertyNameMapping(bool $withoutPropertyNameMapping = true): self
    {
        $this->mapPropertyNames = !$withoutPropertyNameMapping;

        return $this;
    }

    public function withoutMagicalCreation(bool $withoutMagicalCreation = true): self
    {
        $this->disableMagicalCreation = $withoutMagicalCreation;

        return $this;
    }

    public function withMagicalCreation(bool $withMagicalCreation = true): self
    {
        $this->disableMagicalCreation = !$withMagicalCreation;

        return $this;
    }

    public function ignoreMagicalMethod(string ...$methods): self
    {
        $this->ignoredMagicalMethods ??= [];

        array_push($this->ignoredMagicalMethods, ...$methods);

        return $this;
    }

    /**
     * @param string $castable
     * @param Cast|class-string<Cast> $cast
     */
    public function withCast(
        string      $castable,
        Cast|string $cast,
    ): self
    {
        $cast = is_string($cast) ? container()->get($cast) : $cast;

        if ($this->casts === null) {
            $this->casts = new GlobalCastsCollection();
        }

        $this->casts->add($castable, $cast);

        return $this;
    }

    public function withCastCollection(
        GlobalCastsCollection $casts,
    ): self
    {
        if ($this->casts === null) {
            $this->casts = $casts;

            return $this;
        }

        $this->casts->merge($casts);

        return $this;
    }

    public function collect(
        mixed   $items,
        ?string $into = null
    ): array|DataCollection|PaginatedDataCollection|AbstractPaginator|PaginatorContract|Collection
    {
        return DataContainer::get()->dataCollectableFromSomethingResolver()->execute(
            $this->dataClass,
            $this->get(),
            $items,
            $into
        );
    }
}
