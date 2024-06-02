<?php

namespace Deepwell\Data;

use Deepwell\Data\Concerns\AppendableData;
use Deepwell\Data\Concerns\BaseData;
use Deepwell\Data\Concerns\ContextableData;
use Deepwell\Data\Concerns\EmptyData;
use Deepwell\Data\Concerns\IncludeableData;
use Deepwell\Data\Concerns\ResponsableData;
use Deepwell\Data\Concerns\TransformableData;
use Deepwell\Data\Concerns\ValidateableData;
use Deepwell\Data\Concerns\WrappableData;
use Deepwell\Data\Contracts\AppendableData as AppendableDataContract;
use Deepwell\Data\Contracts\BaseData as BaseDataContract;
use Deepwell\Data\Contracts\EmptyData as EmptyDataContract;
use Deepwell\Data\Contracts\IncludeableData as IncludeableDataContract;
use Deepwell\Data\Contracts\ResponsableData as ResponsableDataContract;
use Deepwell\Data\Contracts\TransformableData as TransformableDataContract;
use Deepwell\Data\Contracts\ValidateableData as ValidateableDataContract;
use Deepwell\Data\Contracts\WrappableData as WrappableDataContract;

abstract class Data implements AppendableDataContract, BaseDataContract, TransformableDataContract, IncludeableDataContract, ResponsableDataContract, ValidateableDataContract, WrappableDataContract, EmptyDataContract
{
    use ResponsableData;
    use IncludeableData;
    use AppendableData;
    use ValidateableData;
    use WrappableData;
    use TransformableData;
    use BaseData;
    use EmptyData;
    use ContextableData;
}
