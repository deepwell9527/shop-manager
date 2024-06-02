<?php

namespace Deepwell\Data\Attributes;

use Attribute;
use Deepwell\Data\Casts\Cast;
use Deepwell\Data\Casts\Castable;
use Deepwell\Data\Exceptions\CannotCreateCastAttribute;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_PROPERTY)]
class WithCastable implements GetsCast
{
    public array $arguments;

    public function __construct(
        /** @var Castable $castableClass */
        public string $castableClass,
        mixed         ...$arguments
    )
    {
        if (!is_a($this->castableClass, Castable::class, true)) {
            throw CannotCreateCastAttribute::notACastable();
        }

        $this->arguments = $arguments;
    }

    public function get(): Cast
    {
        return $this->castableClass::dataCastUsing(...$this->arguments);
    }
}
