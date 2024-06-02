<?php

namespace Deepwell\Data\Attributes;

use Attribute;
use Deepwell\Data\Casts\Cast;
use Deepwell\Data\Exceptions\CannotCreateCastAttribute;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_PROPERTY)]
class WithCast implements GetsCast
{
    public array $arguments;

    public function __construct(
        /** @var class-string<Cast> $castClass */
        public string $castClass,
        mixed         ...$arguments
    )
    {
        if (!is_a($this->castClass, Cast::class, true)) {
            throw CannotCreateCastAttribute::notACast();
        }

        $this->arguments = $arguments;
    }

    public function get(): Cast
    {
        return new ($this->castClass)(...$this->arguments);
    }
}
