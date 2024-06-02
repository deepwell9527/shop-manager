<?php

namespace Deepwell\Data\Concerns;

use Hyperf\Contract\PaginatorInterface;
use Hyperf\Paginator\AbstractPaginator;
use Deepwell\Data\CursorPaginatedDataCollection;
use Deepwell\Data\DataCollection;
use Deepwell\Data\PaginatedDataCollection;

/**
 * @property class-string<DataCollection> $_collectionClass
 * @property class-string<PaginatedDataCollection> $_paginatedCollectionClass
 * @property class-string<CursorPaginatedDataCollection> $_cursorPaginatedCollectionClass
 */
trait WithDeprecatedCollectionMethod
{
    /** @deprecated */
    public static function collection(array|AbstractPaginator|PaginatorInterface|DataCollection $items): DataCollection|PaginatedDataCollection
    {
        if ($items instanceof PaginatorInterface || $items instanceof AbstractPaginator) {
            return static::collect(
                $items,
                static::$_paginatedCollectionClass ?? PaginatedDataCollection::class
            );
        }

        return static::collect(
            $items,
            static::$_collectionClass ?? DataCollection::class
        );
    }
}
