<?php

namespace Deepwell\Data\Support\Types\Storage;

use Deepwell\Data\Contracts\BaseData;
use Deepwell\Data\DataCollection;
use Deepwell\Data\Enums\DataTypeKind;
use Deepwell\Data\PaginatedDataCollection;
use Hyperf\Collection\Enumerable;
use Hyperf\Contract\PaginatorInterface;
use Hyperf\Paginator\AbstractPaginator;

class AcceptedTypesStorage
{
    /** @var array<string, string[]> */
    public static array $acceptedTypes = [];

    /** @var array<string, DataTypeKind> */
    public static array $acceptedKinds = [];

    /** @return array{acceptedTypes:string[], kind: DataTypeKind} */
    public static function getAcceptedTypesAndKind(string $name): array
    {
        $acceptedTypes = static::getAcceptedTypes($name);

        return [
            'acceptedTypes' => $acceptedTypes,
            'kind' => static::$acceptedKinds[$name] ??= static::resolveDataTypeKind($name, $acceptedTypes),
        ];
    }

    /** @return string[] */
    public static function getAcceptedTypes(string $name): array
    {
        return static::$acceptedTypes[$name] ??= static::resolveAcceptedTypes($name);
    }

    /** @return string[] */
    protected static function resolveAcceptedTypes(string $name): array
    {
        if (!class_exists($name) && !interface_exists($name)) {
            return [];
        }

        return array_unique([
            ...array_values(class_parents($name)),
            ...array_values(class_implements($name)),
        ]);
    }

    protected static function resolveDataTypeKind(string $name, array $acceptedTypes): DataTypeKind
    {
        return match (true) {
            in_array(BaseData::class, $acceptedTypes) => DataTypeKind::DataObject,
            $name === 'array' => DataTypeKind::Array,
            in_array(Enumerable::class, $acceptedTypes) => DataTypeKind::Enumerable,
            in_array(DataCollection::class, $acceptedTypes) || $name === DataCollection::class => DataTypeKind::DataCollection,
            in_array(PaginatedDataCollection::class, $acceptedTypes) || $name === PaginatedDataCollection::class => DataTypeKind::DataPaginatedCollection,
            in_array(PaginatorInterface::class, $acceptedTypes) || in_array(AbstractPaginator::class, $acceptedTypes) => DataTypeKind::Paginator,
            default => DataTypeKind::Default,
        };
    }

    public static function reset(): void
    {
        static::$acceptedTypes = [];
        static::$acceptedKinds = [];
    }
}
