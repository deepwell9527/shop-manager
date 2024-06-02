<?php

namespace Deepwell\Data;

use Deepwell\Data\Concerns\AppendableData;
use Deepwell\Data\Concerns\BaseData;
use Deepwell\Data\Concerns\ContextableData;
use Deepwell\Data\Concerns\EmptyData;
use Deepwell\Data\Concerns\IncludeableData;
use Deepwell\Data\Concerns\ResponsableData;
use Deepwell\Data\Concerns\TransformableData;
use Deepwell\Data\Concerns\WrappableData;
use Deepwell\Data\Contracts\AppendableData as AppendableDataContract;
use Deepwell\Data\Contracts\BaseData as BaseDataContract;
use Deepwell\Data\Contracts\EmptyData as EmptyDataContract;
use Deepwell\Data\Contracts\IncludeableData as IncludeableDataContract;
use Deepwell\Data\Contracts\ResponsableData as ResponsableDataContract;
use Deepwell\Data\Contracts\TransformableData as TransformableDataContract;
use Deepwell\Data\Contracts\WrappableData as WrappableDataContract;
use Deepwell\Data\DataPipes\CastPropertiesDataPipe;
use Deepwell\Data\DataPipes\DefaultValuesDataPipe;
use Deepwell\Data\DataPipes\FillRouteParameterPropertiesDataPipe;
use Deepwell\Data\DataPipes\MapPropertiesDataPipe;

class Resource implements BaseDataContract, AppendableDataContract, IncludeableDataContract, TransformableDataContract, ResponsableDataContract, WrappableDataContract, EmptyDataContract
{
    use BaseData;
    use AppendableData;
    use IncludeableData;
    use ResponsableData;
    use TransformableData;
    use WrappableData;
    use EmptyData;
    use ContextableData;

    public static function pipeline(): DataPipeline
    {
        return DataPipeline::create()
            ->into(static::class)
            ->through(MapPropertiesDataPipe::class)
            ->through(FillRouteParameterPropertiesDataPipe::class)
            ->through(DefaultValuesDataPipe::class)
            ->through(CastPropertiesDataPipe::class);
    }
}
