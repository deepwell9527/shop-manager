<?php

namespace Deepwell\Data\Transformers;

use DateTimeInterface;
use DateTimeZone;
use Deepwell\Data\Support\DataProperty;
use Deepwell\Data\Support\Transformation\TransformationContext;
use Hyperf\Collection\Arr;

class DateTimeInterfaceTransformer implements Transformer
{
    protected string $format;

    public function __construct(
        ?string $format = null,
        protected ?string $setTimeZone = null
    ) {
        [$this->format] = Arr::wrap($format ?? config('data.date_format'));
    }

    public function transform(DataProperty $property, mixed $value, TransformationContext $context): string
    {
        /** @var DateTimeInterface $value */
        if ($this->setTimeZone) {
            $value = (clone $value)->setTimezone(new DateTimeZone($this->setTimeZone));
        }

        return $value->format(ltrim($this->format, '!'));
    }
}
