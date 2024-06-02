<?php

namespace Deepwell\Data\Attributes;

use Attribute;
use Deepwell\Data\Contracts\BaseData;
use Deepwell\Data\Exceptions\CannotFindDataClass;

#[Attribute(Attribute::TARGET_PROPERTY)]
class DataCollectionOf
{
    public function __construct(
        /** @var class-string<BaseData> $class */
        public string $class
    )
    {
        if (!is_subclass_of($this->class, BaseData::class)) {
            throw new CannotFindDataClass("Class {$this->class} given does not implement `BaseData::class`");
        }
    }
}
