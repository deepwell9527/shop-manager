<?php

namespace Deepwell\Data\Concerns;

use Deepwell\Data\Support\DataContainer;
use Deepwell\Data\Support\Partials\PartialType;
use Deepwell\Data\Support\Transformation\TransformationContextFactory;
use Deepwell\Data\Support\Wrapping\WrapExecutionType;
use Hyperf\Context\ApplicationContext;
use Hyperf\HttpServer\Contract\ResponseInterface;

trait ResponsableData
{
    public static function allowedRequestIncludes(): ?array
    {
        return [];
    }

    public static function allowedRequestExcludes(): ?array
    {
        return [];
    }

    public static function allowedRequestOnly(): ?array
    {
        return [];
    }

    public static function allowedRequestExcept(): ?array
    {
        return [];
    }

    public function toResponse($request)
    {
        $contextFactory = TransformationContextFactory::create()
            ->withWrapExecutionType(WrapExecutionType::Enabled);

        $includePartials = DataContainer::get()->requestQueryStringPartialsResolver()->execute(
            $this,
            $request,
            PartialType::Include
        );

        if ($includePartials) {
            $contextFactory->mergeIncludePartials($includePartials);
        }

        $excludePartials = DataContainer::get()->requestQueryStringPartialsResolver()->execute(
            $this,
            $request,
            PartialType::Exclude
        );

        if ($excludePartials) {
            $contextFactory->mergeExcludePartials($excludePartials);
        }

        $onlyPartials = DataContainer::get()->requestQueryStringPartialsResolver()->execute(
            $this,
            $request,
            PartialType::Only
        );

        if ($onlyPartials) {
            $contextFactory->mergeOnlyPartials($onlyPartials);
        }

        $exceptPartials = DataContainer::get()->requestQueryStringPartialsResolver()->execute(
            $this,
            $request,
            PartialType::Except
        );

        if ($exceptPartials) {
            $contextFactory->mergeExceptPartials($exceptPartials);
        }
        return ApplicationContext::getContainer()->get(ResponseInterface::class)->json(
            data: $this->transform($contextFactory),
        );
    }
}
