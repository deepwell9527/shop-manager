<?php

namespace Deepwell\Data;

use Deepwell\Data\Concerns\BaseData;
use Deepwell\Data\Concerns\ValidateableData;
use Deepwell\Data\Contracts\BaseData as BaseDataContract;
use Deepwell\Data\Contracts\ValidateableData as ValidateableDataContract;

class Dto implements ValidateableDataContract, BaseDataContract
{
    use ValidateableData;
    use BaseData;
}
