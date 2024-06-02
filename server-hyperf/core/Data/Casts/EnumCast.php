<?php

namespace Deepwell\Data\Casts;

use BackedEnum;
use Deepwell\Data\Exceptions\CannotCastEnum;
use Deepwell\Data\Support\Creation\CreationContext;
use Deepwell\Data\Support\DataProperty;
use Throwable;

class EnumCast implements Cast, IterableItemCast
{
    public function __construct(
        protected ?string $type = null
    )
    {
    }

    public function cast(DataProperty $property, mixed $value, array $properties, CreationContext $context): BackedEnum|Uncastable
    {
        return $this->castValue(
            $this->type ?? $property->type->type->findAcceptedTypeForBaseType(BackedEnum::class),
            $value
        );
    }

    protected function castValue(
        ?string $type,
        mixed   $value
    ): BackedEnum|Uncastable
    {
        if ($type === null) {
            return Uncastable::create();
        }

        /** @var BackedEnum $type */
        try {
            return $type::from($value);
        } catch (Throwable $e) {
            throw CannotCastEnum::create($type, $value);
        }
    }

    public function castIterableItem(DataProperty $property, mixed $value, array $properties, CreationContext $context): BackedEnum|Uncastable
    {
        return $this->castValue($property->type->iterableItemType, $value);
    }
}
