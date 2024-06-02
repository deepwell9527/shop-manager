<?php

namespace Deepwell\Data\Attributes;

use Attribute;
use Deepwell\Data\Casts\Cast;
use Deepwell\Data\Exceptions\CannotCreateCastAttribute;
use Deepwell\Data\Exceptions\CannotCreateTransformerAttribute;
use Deepwell\Data\Transformers\Transformer;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_PROPERTY)]
class WithCastAndTransformer implements GetsCast
{
    public array $arguments;

    public function __construct(
        /** @var Transformer&Cast $class */
        public string $class,
        mixed         ...$arguments
    )
    {
        if (!is_a($this->class, Transformer::class, true)) {
            throw CannotCreateTransformerAttribute::notATransformer();
        }

        if (!is_a($this->class, Cast::class, true)) {
            throw CannotCreateCastAttribute::notACast();
        }

        $this->arguments = $arguments;
    }

    public function get(): Cast&Transformer
    {
        return new ($this->class)(...$this->arguments);
    }
}
