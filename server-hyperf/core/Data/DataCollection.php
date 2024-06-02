<?php

namespace Deepwell\Data;

use ArrayAccess;
use Countable;
use Deepwell\Data\Concerns\BaseDataCollectable;
use Deepwell\Data\Concerns\ContextableData;
use Deepwell\Data\Concerns\IncludeableData;
use Deepwell\Data\Concerns\ResponsableData;
use Deepwell\Data\Concerns\TransformableData;
use Deepwell\Data\Concerns\WrappableData;
use Deepwell\Data\Contracts\BaseData;
use Deepwell\Data\Contracts\BaseDataCollectable as BaseDataCollectableContract;
use Deepwell\Data\Contracts\IncludeableData as IncludeableDataContract;
use Deepwell\Data\Contracts\ResponsableData as ResponsableDataContract;
use Deepwell\Data\Contracts\TransformableData as TransformableDataContract;
use Deepwell\Data\Contracts\WrappableData as WrappableDataContract;
use Deepwell\Data\Exceptions\CannotCastData;
use Deepwell\Data\Exceptions\InvalidDataCollectionOperation;
use Deepwell\Data\Support\EloquentCasts\DataCollectionEloquentCast;
use Hyperf\Collection\Collection;
use Hyperf\Collection\Enumerable;
use IteratorAggregate;

/**
 * @template TKey of array-key
 * @template TValue
 *
 * @implements ArrayAccess<TKey, TValue>
 * @implements  IteratorAggregate<TKey, TValue>
 */
class DataCollection implements BaseDataCollectableContract, TransformableDataContract, ResponsableDataContract, IncludeableDataContract, WrappableDataContract, IteratorAggregate, Countable, ArrayAccess
{
    use BaseDataCollectable;
    use ResponsableData;
    use IncludeableData;
    use WrappableData;
    use TransformableData;
    use ContextableData;

    protected Enumerable $items;

    /**
     * @param class-string<TValue> $dataClass
     * @param Enumerable|array|DataCollection|null $items
     */
    public function __construct(
        public readonly string               $dataClass,
        Enumerable|array|DataCollection|null $items
    )
    {
        if (is_array($items) || is_null($items)) {
            $items = new Collection($items);
        }

        if ($items instanceof DataCollection) {
            $items = $items->toCollection();
        }

        $this->items = $items->map(
            fn($item) => $item instanceof $this->dataClass ? $item : $this->dataClass::from($item)
        );
    }

    public function toCollection(): Enumerable
    {
        return $this->items;
    }

    public static function castUsing(array $arguments)
    {
        if (count($arguments) < 1) {
            throw CannotCastData::dataCollectionTypeRequired();
        }

        return new DataCollectionEloquentCast($arguments[0], static::class, array_slice($arguments, 1));
    }

    public function items(): array
    {
        return $this->items->all();
    }

    /**
     * @param TKey $offset
     *
     * @return bool
     * @throws InvalidDataCollectionOperation
     */
    public function offsetExists($offset): bool
    {
        if (!$this->items instanceof ArrayAccess) {
            throw InvalidDataCollectionOperation::create();
        }

        return $this->items->offsetExists($offset);
    }

    /**
     * @param TKey $offset
     *
     * @return TValue
     * @throws InvalidDataCollectionOperation
     */
    public function offsetGet($offset): mixed
    {
        if (!$this->items instanceof ArrayAccess) {
            throw InvalidDataCollectionOperation::create();
        }

        $data = $this->items->offsetGet($offset);

        if ($data instanceof IncludeableDataContract) {
            $data->getDataContext()->mergePartials($this->getDataContext());
        }

        return $data;
    }

    /**
     * @param TKey|null $offset
     * @param TValue $value
     *
     * @return void
     * @throws InvalidDataCollectionOperation
     */
    public function offsetSet($offset, $value): void
    {
        if (!$this->items instanceof ArrayAccess) {
            throw InvalidDataCollectionOperation::create();
        }

        $value = $value instanceof BaseData
            ? $value
            : $this->dataClass::from($value);

        $this->items->offsetSet($offset, $value);
    }

    /**
     * @param TKey $offset
     *
     * @return void
     * @throws InvalidDataCollectionOperation
     */
    public function offsetUnset($offset): void
    {
        if (!$this->items instanceof ArrayAccess) {
            throw InvalidDataCollectionOperation::create();
        }

        $this->items->offsetUnset($offset);
    }
}
