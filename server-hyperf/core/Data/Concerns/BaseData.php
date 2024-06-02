<?php

namespace Deepwell\Data\Concerns;

use Hyperf\Collection\Enumerable;
use Hyperf\Contract\PaginatorInterface as PaginatorContract;
use Hyperf\Paginator\AbstractPaginator;
use Hyperf\Collection\Collection;
use Deepwell\Data\DataCollection;
use Deepwell\Data\DataPipeline;
use Deepwell\Data\DataPipes\AuthorizedDataPipe;
use Deepwell\Data\DataPipes\CastPropertiesDataPipe;
use Deepwell\Data\DataPipes\DefaultValuesDataPipe;
use Deepwell\Data\DataPipes\FillRouteParameterPropertiesDataPipe;
use Deepwell\Data\DataPipes\MapPropertiesDataPipe;
use Deepwell\Data\DataPipes\ValidatePropertiesDataPipe;
use Deepwell\Data\PaginatedDataCollection;
use Deepwell\Data\Support\Creation\CreationContext;
use Deepwell\Data\Support\Creation\CreationContextFactory;
use Deepwell\Data\Support\DataConfig;
use Deepwell\Data\Support\DataProperty;

trait BaseData
{
    public static function optional(mixed ...$payloads): ?static
    {
        if (count($payloads) === 0) {
            return null;
        }

        foreach ($payloads as $payload) {
            if ($payload !== null) {
                return static::from(...$payloads);
            }
        }

        return null;
    }

    public static function from(mixed ...$payloads): static
    {
        return static::factory()->from(...$payloads);
    }

    public static function collect(mixed $items, ?string $into = null): array|DataCollection|PaginatedDataCollection|AbstractPaginator|PaginatorContract|Enumerable
    {
        return static::factory()->collect($items, $into);
    }

    public static function factory(?CreationContext $creationContext = null): CreationContextFactory
    {
        if ($creationContext) {
            return CreationContextFactory::createFromCreationContext(static::class, $creationContext);
        }

        return CreationContextFactory::createFromConfig(static::class);
    }

    public static function normalizers(): array
    {
        return config('data.normalizers');
    }

    public static function pipeline(): DataPipeline
    {
        return DataPipeline::create()
            ->into(static::class)
            ->through(AuthorizedDataPipe::class)
            ->through(MapPropertiesDataPipe::class)
            ->through(FillRouteParameterPropertiesDataPipe::class)
            ->through(ValidatePropertiesDataPipe::class)
            ->through(DefaultValuesDataPipe::class)
            ->through(CastPropertiesDataPipe::class);
    }

    public static function prepareForPipeline(array $properties): array
    {
        return $properties;
    }

    public function __sleep(): array
    {
        $dataClass = container()->get(DataConfig::class)->getDataClass(static::class);

        return $dataClass
            ->properties
            ->map(fn (DataProperty $property) => $property->name)
            ->when($dataClass->appendable, fn (Collection $properties) => $properties->push('_additional'))
            ->when(property_exists($this, '_dataContext'), fn (Collection $properties) => $properties->push('_dataContext'))
            ->toArray();
    }
}
