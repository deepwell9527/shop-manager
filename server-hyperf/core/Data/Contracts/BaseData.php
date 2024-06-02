<?php

namespace Deepwell\Data\Contracts;

use Deepwell\Data\DataCollection;
use Deepwell\Data\DataPipeline;
use Deepwell\Data\PaginatedDataCollection;
use Deepwell\Data\Support\Creation\CreationContext;
use Deepwell\Data\Support\Creation\CreationContextFactory;
use Hyperf\Collection\Enumerable;
use Hyperf\Contract\PaginatorInterface as PaginatorContract;
use Hyperf\Database\Model\Collection as EloquentCollection;
use Hyperf\Paginator\AbstractPaginator;

/**
 * @template TData
 * @template TValue of mixed
 * @template TKey of array-key
 */
interface BaseData
{

    public static function optional(mixed ...$payloads): ?static;


    public static function from(mixed ...$payloads): static;

    /**
     * @param Enumerable<TKey, TValue>|EloquentCollection<TKey, TValue>|array<TKey, TValue>|AbstractPaginator|PaginatorContract|DataCollection<TKey, TValue> $items
     */
    public static function collect(mixed $items, ?string $into = null): array|DataCollection|PaginatedDataCollection|AbstractPaginator|PaginatorContract|Enumerable;

    /**
     * @return CreationContextFactory<static>
     */
    public static function factory(?CreationContext $creationContext = null): CreationContextFactory;

    public static function normalizers(): array;

    public static function prepareForPipeline(array $properties): array;

    public static function pipeline(): DataPipeline;
}
