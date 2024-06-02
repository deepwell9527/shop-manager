<?php

namespace Deepwell\Data\Resolvers\Concerns;

use Deepwell\Data\Exceptions\MaxTransformationDepthReached;
use Deepwell\Data\Support\Transformation\TransformationContext;

trait ChecksTransformationDepth
{
    public function hasReachedMaxTransformationDepth(TransformationContext $context): bool
    {
        return $context->maxDepth !== null && $context->depth >= $context->maxDepth;
    }

    public function handleMaxDepthReached(TransformationContext $context): array
    {
        if ($context->throwWhenMaxDepthReached) {
            throw MaxTransformationDepthReached::create($context->maxDepth);
        }

        return [];
    }
}
