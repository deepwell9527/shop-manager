<?php

namespace Deepwell\Data\Contracts;

use Deepwell\Data\DataCollection;
use Deepwell\Data\PaginatedDataCollection;
use Hyperf\Paginator\AbstractPaginator;
use Hyperf\Paginator\Paginator;

/**
 * @template TValue
 */
interface DeprecatedData
{
    public static function collection(array|AbstractPaginator|Paginator|DataCollection $items): DataCollection|PaginatedDataCollection;
}
