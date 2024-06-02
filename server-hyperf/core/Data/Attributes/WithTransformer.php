<?php

namespace Deepwell\Data\Attributes;

use Attribute;
use Deepwell\Data\Exceptions\CannotCreateTransformerAttribute;
use Deepwell\Data\Transformers\Transformer;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_PROPERTY)]
class WithTransformer
{
    public array $arguments;

    public function __construct(
        /** @var Transformer $transformerClass */
        public string $transformerClass,
        mixed         ...$arguments
    )
    {
        if (!is_a($this->transformerClass, Transformer::class, true)) {
            throw CannotCreateTransformerAttribute::notATransformer();
        }

        $this->arguments = $arguments;
    }

    public function get(): Transformer
    {
        return new ($this->transformerClass)(...$this->arguments);
    }
}
