<?php

namespace Deepwell\Data\Contracts;

use Deepwell\Data\Support\Transformation\TransformationContext;
use Deepwell\Data\Support\Transformation\TransformationContextFactory;
use Hyperf\Contract\Arrayable;
use Deepwell\Data\Casts\Castable;
use JsonSerializable;

interface TransformableData extends JsonSerializable, Jsonable, Arrayable, Castable, ContextableData
{
    public static function castUsing(array $arguments);

    public function transform(
        null|TransformationContextFactory|TransformationContext $transformationContext = null,
    ): array;

    public function all(): array;

    public function toArray(): array;

    public function toJson($options = 0): string;

    public function jsonSerialize(): array;
}
