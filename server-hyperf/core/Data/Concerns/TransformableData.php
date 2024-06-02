<?php

namespace Deepwell\Data\Concerns;

use Deepwell\Data\Contracts\BaseData as BaseDataContract;
use Deepwell\Data\Contracts\BaseDataCollectable as BaseDataCollectableContract;
use Deepwell\Data\Contracts\IncludeableData as IncludeableDataContract;
use Deepwell\Data\Support\DataContainer;
use Deepwell\Data\Support\EloquentCasts\DataEloquentCast;
use Deepwell\Data\Support\Transformation\TransformationContext;
use Deepwell\Data\Support\Transformation\TransformationContextFactory;
use Exception;

trait TransformableData
{
    use ContextableData;

    public static function castUsing(array $arguments)
    {
        return new DataEloquentCast(static::class, $arguments);
    }

    public function all(): array
    {
        return $this->transform(TransformationContextFactory::create()->withValueTransformation(false));
    }

    public function transform(
        null|TransformationContextFactory|TransformationContext $transformationContext = null,
    ): array
    {
        $transformationContext = match (true) {
            $transformationContext instanceof TransformationContext => $transformationContext,
            $transformationContext instanceof TransformationContextFactory => $transformationContext->get($this),
            $transformationContext === null => new TransformationContext(
                maxDepth: config('data.max_transformation_depth'),
                throwWhenMaxDepthReached: config('data.throw_when_max_transformation_depth_reached')
            )
        };

        $resolver = match (true) {
            $this instanceof BaseDataContract => DataContainer::get()->transformedDataResolver(),
            $this instanceof BaseDataCollectableContract => DataContainer::get()->transformedDataCollectableResolver(),
            default => throw new Exception('Cannot transform data object')
        };

        if ($this instanceof IncludeableDataContract) {
            $transformationContext->mergePartialsFromDataContext($this);
        }

        return $resolver->execute($this, $transformationContext);
    }

    public function toArray(): array
    {
        return $this->transform();
    }

    public function toJson($options = 0): string
    {
        return json_encode($this->transform(), $options);
    }

    public function jsonSerialize(): array
    {
        return $this->transform();
    }
}
