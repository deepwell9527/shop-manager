<?php

namespace Deepwell\Data;

use Closure;
use Countable;
use Deepwell\Data\Casts\Cast;
use Hyperf\Contract\PaginatorInterface;
use Hyperf\Paginator\AbstractPaginator;
use IteratorAggregate;
use Deepwell\Data\Concerns\BaseDataCollectable;
use Deepwell\Data\Concerns\ContextableData;
use Deepwell\Data\Concerns\IncludeableData;
use Deepwell\Data\Concerns\ResponsableData;
use Deepwell\Data\Concerns\TransformableData;
use Deepwell\Data\Concerns\WrappableData;
use Deepwell\Data\Contracts\BaseDataCollectable as BaseDataCollectableContract;
use Deepwell\Data\Contracts\IncludeableData as IncludeableDataContract;
use Deepwell\Data\Contracts\ResponsableData as ResponsableDataContract;
use Deepwell\Data\Contracts\TransformableData as TransformableDataContract;
use Deepwell\Data\Contracts\WrappableData as WrappableDataContract;
use Deepwell\Data\Exceptions\CannotCastData;
use Deepwell\Data\Exceptions\PaginatedCollectionIsAlwaysWrapped;
use Deepwell\Data\Support\EloquentCasts\DataCollectionEloquentCast;

/**
 * @template TKey of array-key
 * @template TValue
 *
 * @implements IteratorAggregate<TKey, TValue>
 */
class PaginatedDataCollection implements  BaseDataCollectableContract, TransformableDataContract, ResponsableDataContract, IncludeableDataContract, WrappableDataContract, IteratorAggregate, Countable
{
    use ResponsableData;
    use IncludeableData;
    use WrappableData;
    use TransformableData;

    use BaseDataCollectable;
    use ContextableData;

    protected PaginatorInterface $items;

    public function __construct(
        public readonly string $dataClass,
        AbstractPaginator $items
    ) {
        $this->items = $items->getCollection()->map(
            fn ($item) => $item instanceof $this->dataClass ? $item : $this->dataClass::from($item)
        );
    }

    /**
     * @param Closure(TValue, TKey): TValue $through
     *
     * @return static<TKey, TValue>
     */
    public function through(Closure $through): static
    {
        $clone = clone $this;

        $clone->items = $clone->items->through($through);

        return $clone;
    }

    public function items(): AbstractPaginator
    {
        return $this->items;
    }

    public static function castUsing(array $arguments)
    {
        if (count($arguments) !== 1) {
            throw CannotCastData::dataCollectionTypeRequired();
        }

        return new DataCollectionEloquentCast(current($arguments));
    }

    public function withoutWrapping(): static
    {
        throw PaginatedCollectionIsAlwaysWrapped::create();
    }
}
