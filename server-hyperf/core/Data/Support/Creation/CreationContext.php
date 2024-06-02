<?php

namespace Deepwell\Data\Support\Creation;

use Deepwell\Data\Contracts\BaseData;
use Deepwell\Data\DataCollection;
use Deepwell\Data\PaginatedDataCollection;
use Deepwell\Data\Support\DataContainer;
use Hyperf\Collection\Collection;
use Hyperf\Contract\PaginatorInterface as PaginatorContract;
use Hyperf\Paginator\AbstractPaginator;

/**
 * @template TData of BaseData
 */
class CreationContext
{
    /**
     * @param class-string<TData> $dataClass
     * @param array<string|int> $currentPath
     */
    public function __construct(
        public string                          $dataClass,
        public array                           $mappedProperties,
        public array                           $currentPath,
        public ValidationStrategy              $validationStrategy,
        public readonly bool                   $mapPropertyNames,
        public readonly bool                   $disableMagicalCreation,
        public readonly ?array                 $ignoredMagicalMethods,
        public readonly ?GlobalCastsCollection $casts,
    )
    {
    }

    /**
     * @return TData
     */
    public function from(mixed ...$payloads): BaseData
    {
        return DataContainer::get()->dataFromSomethingResolver()->execute(
            $this->dataClass,
            $this,
            ...$payloads
        );
    }

    public function collect(
        mixed   $items,
        ?string $into = null
    ): array|DataCollection|PaginatedDataCollection|Collection|AbstractPaginator|PaginatorContract
    {
        return DataContainer::get()->dataCollectableFromSomethingResolver()->execute(
            $this->dataClass,
            $this,
            $items,
            $into
        );
    }

    /** @internal */
    public function next(
        string     $dataClass,
        string|int $path,
    ): self
    {
        $this->dataClass = $dataClass;

        $this->currentPath[] = $path;

        return $this;
    }

    /** @internal */
    public function previous(): self
    {
        array_pop($this->currentPath);

        return $this;
    }
}
