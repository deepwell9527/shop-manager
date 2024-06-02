<?php

namespace Deepwell\Data\Resolvers;

use Closure;
use Deepwell\Data\DataCollection;
use Deepwell\Data\Enums\CustomCreationMethodType;
use Deepwell\Data\Enums\DataTypeKind;
use Deepwell\Data\Exceptions\CannotCreateDataCollectable;
use Deepwell\Data\PaginatedDataCollection;
use Deepwell\Data\Support\Creation\CollectableMetaData;
use Deepwell\Data\Support\Creation\CreationContext;
use Deepwell\Data\Support\DataConfig;
use Deepwell\Data\Support\DataMethod;
use Deepwell\Data\Support\Factories\DataReturnTypeFactory;
use Deepwell\Data\Support\Types\NamedType;
use Exception;
use Hyperf\Collection\Collection;
use Hyperf\Contract\PaginatorInterface;
use Hyperf\Paginator\AbstractPaginator;
use Hyperf\Paginator\LengthAwarePaginator;

class DataCollectableFromSomethingResolver
{
    public function __construct(
        protected DataConfig                $dataConfig,
        protected DataFromSomethingResolver $dataFromSomethingResolver,
        protected DataReturnTypeFactory     $dataReturnTypeFactory,
    )
    {
    }

    public function execute(
        string          $dataClass,
        CreationContext $creationContext,
        mixed           $items,
        ?string         $into = null,
    ): array|DataCollection|PaginatedDataCollection|AbstractPaginator|PaginatorInterface|Collection
    {
        $collectable = $this->createFromCustomCreationMethod($dataClass, $creationContext, $items, $into);

        if ($collectable) {
            return $collectable;
        }

        /** @var NamedType $intoType */
        $intoType = $into !== null
            ? $this->dataReturnTypeFactory->buildFromNamedType($into, $dataClass, nullable: false)->type
            : $this->dataReturnTypeFactory->buildFromValue($items, $dataClass, nullable: false)->type;

        $collectableMetaData = CollectableMetaData::fromOther($items);

        $normalizedItems = $this->normalizeItems($items, $dataClass, $creationContext);

        return match ($intoType->kind) {
            DataTypeKind::DataArray, DataTypeKind::Array => $this->normalizeToArray($normalizedItems),
            DataTypeKind::DataEnumerable, DataTypeKind::Enumerable => new $intoType->name($this->normalizeToArray($normalizedItems)),
            DataTypeKind::DataCollection => new $intoType->name($dataClass, $this->normalizeToArray($normalizedItems)),
            DataTypeKind::DataPaginatedCollection => new $intoType->name($dataClass, $this->normalizeToPaginator($normalizedItems, $collectableMetaData)),
            DataTypeKind::DataPaginator, DataTypeKind::Paginator => $this->normalizeToPaginator($normalizedItems, $collectableMetaData),
            default => throw CannotCreateDataCollectable::create(get_debug_type($items), $intoType->name)
        };
    }

    protected function createFromCustomCreationMethod(
        string          $dataClass,
        CreationContext $creationContext,
        mixed           $items,
        ?string         $into,
    ): null|array|DataCollection|PaginatedDataCollection|AbstractPaginator|PaginatorInterface|Collection
    {
        if ($creationContext->disableMagicalCreation) {
            return null;
        }

        /** @var ?DataMethod $method */
        $method = $this->dataConfig
            ->getDataClass($dataClass)
            ->methods
            ->filter(function (DataMethod $method) use ($creationContext, $into, $items) {
                if (
                    $method->customCreationMethodType !== CustomCreationMethodType::Collection
                ) {
                    return false;
                }

                if (
                    $creationContext->ignoredMagicalMethods !== null
                    && in_array($method->name, $creationContext->ignoredMagicalMethods)
                ) {
                    return false;
                }

                if ($into !== null && !$method->returns($into)) {
                    return false;
                }

                return $method->accepts($items);
            })
            ->first();

        if ($method === null) {
            return null;
        }

        $payload = [];

        foreach ($method->parameters as $parameter) {
            if ($parameter->type->type->isCreationContext()) {
                $payload[$parameter->name] = $creationContext;
            } else {
                $payload[$parameter->name] = $this->normalizeItems($items, $dataClass, $creationContext);
            }
        }

        return $dataClass::{$method->name}(...$payload);
    }

    protected function normalizeItems(
        mixed           $items,
        string          $dataClass,
        CreationContext $creationContext,
    ): array|PaginatorInterface|AbstractPaginator|Collection
    {
        if ($items instanceof PaginatedDataCollection
            || $items instanceof DataCollection
        ) {
            $items = $items->items();
        }

        if ($items instanceof AbstractPaginator) {
            return $items->getCollection()->map($this->itemsToDataClosure($dataClass, $creationContext));
        }

        if ($items instanceof Collection) {
            return $items->map($this->itemsToDataClosure($dataClass, $creationContext));
        }

        if (is_array($items)) {
            $payload = [];

            foreach ($items as $index => $item) {
                $payload[$index] = $this->itemsToDataClosure($dataClass, $creationContext)($item, $index);
            }

            return $payload;
        }

        if ($items === null) {
            return [];
        }

        throw new Exception('Unable to normalize items');
    }

    protected function itemsToDataClosure(
        string          $dataClass,
        CreationContext $creationContext
    ): Closure
    {
        return function (mixed $data, int|string $index) use ($dataClass, $creationContext) {
            if ($data instanceof $dataClass) {
                return $data;
            }

            $creationContext->next($dataClass, $index);

            $data = $creationContext->from($data);

            $creationContext->previous();

            return $data;
        };
    }

    protected function normalizeToArray(
        array|AbstractPaginator|Collection $items,
    ): array
    {
        if ($items instanceof Collection) {
            return $items->all();
        }

        return is_array($items)
            ? $items
            : $items->items();
    }

    protected function normalizeToPaginator(
        array|AbstractPaginator $items,
        CollectableMetaData     $collectableMetaData,
    ): AbstractPaginator
    {
        if ($items instanceof AbstractPaginator) {
            return $items;
        }

        $normalizedItems = $this->normalizeToArray($items);

        return new LengthAwarePaginator(
            $normalizedItems,
            $collectableMetaData->paginator_total ?? count($items),
            $collectableMetaData->paginator_per_page ?? 15,
        );
    }
}
