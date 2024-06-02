<?php

namespace Deepwell\Data\Resolvers;

use Closure;
use Deepwell\Data\Contracts\BaseData;
use Deepwell\Data\Contracts\TransformableData;
use Deepwell\Data\Contracts\WrappableData;
use Deepwell\Data\CursorPaginatedDataCollection;
use Deepwell\Data\DataCollection;
use Deepwell\Data\PaginatedDataCollection;
use Deepwell\Data\Resolvers\Concerns\ChecksTransformationDepth;
use Deepwell\Data\Support\DataConfig;
use Deepwell\Data\Support\Transformation\TransformationContext;
use Deepwell\Data\Support\Wrapping\Wrap;
use Deepwell\Data\Support\Wrapping\WrapExecutionType;
use Deepwell\Data\Support\Wrapping\WrapType;
use Exception;
use Hyperf\Collection\Arr;
use Hyperf\Collection\Collection;
use Hyperf\Paginator\AbstractPaginator;

class TransformedDataCollectableResolver
{
    use ChecksTransformationDepth;

    public function __construct(
        protected DataConfig $dataConfig
    )
    {
    }

    public function execute(
        iterable              $items,
        TransformationContext $context,
    ): array
    {
        if ($this->hasReachedMaxTransformationDepth($context)) {
            return $this->handleMaxDepthReached($context);
        }

        $wrap = $items instanceof WrappableData
            ? $items->getWrap()
            : new Wrap(WrapType::UseGlobal);

        $executeWrap = $context->wrapExecutionType->shouldExecute();

        $nestedContext = $executeWrap
            ? $context->setWrapExecutionType(WrapExecutionType::TemporarilyDisabled)
            : $context;

        if ($items instanceof DataCollection) {
            return $this->transformItems($items->items(), $wrap, $executeWrap, $nestedContext);
        }

        if ($items instanceof Collection || is_array($items)) {
            return $this->transformItems($items, $wrap, $executeWrap, $nestedContext);
        }

        if ($items instanceof PaginatedDataCollection || $items instanceof CursorPaginatedDataCollection) {
            return $this->transformPaginator($items->items(), $wrap, $nestedContext);
        }

        if ($items instanceof AbstractPaginator) {
            return $this->transformPaginator($items, $wrap, $nestedContext);
        }

        throw new Exception("Cannot transform collection");
    }

    protected function transformItems(
        Collection|array      $items,
        Wrap                  $wrap,
        bool                  $executeWrap,
        TransformationContext $nestedContext,
    ): array
    {
        $collection = [];

        foreach ($items as $key => $value) {
            $collection[$key] = $this->transformationClosure($nestedContext)($value);
        }

        return $executeWrap
            ? $wrap->wrap($collection)
            : $collection;
    }

    protected function transformationClosure(
        TransformationContext $nestedContext,
    ): Closure
    {
        return function (BaseData $data) use ($nestedContext) {
            if (!$data instanceof TransformableData) {
                return $data;
            }

            if ($nestedContext->transformValues === false && $nestedContext->hasPartials()) {
                $data->getDataContext()->mergeTransformationContext($nestedContext);

                return $data;
            }

            if ($nestedContext->transformValues === false) {
                return $data;
            }

            return $data->transform(clone $nestedContext);
        };
    }

    protected function transformPaginator(
        AbstractPaginator     $paginator,
        Wrap                  $wrap,
        TransformationContext $nestedContext,
    ): array
    {

        if ($nestedContext->transformValues === false) {
            return $paginator->getCollection()->map(fn(BaseData $data) => $this->transformationClosure($nestedContext)($data))->all();
        }

        $paginated = $paginator->toArray();

        $wrapKey = $wrap->getKey() ?? 'data';

        return [
            $wrapKey => array_map(fn(BaseData $data) => $this->transformationClosure($nestedContext)($data), $paginator->items()),
            'links' => $paginated['links'] ?? [],
            'meta' => Arr::except($paginated, [
                'data',
                'links',
            ]),
        ];
    }
}
