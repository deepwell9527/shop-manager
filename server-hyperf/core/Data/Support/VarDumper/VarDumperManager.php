<?php

namespace Deepwell\Data\Support\VarDumper;

use Deepwell\Data\Contracts\BaseData;
use Deepwell\Data\Contracts\BaseDataCollectable;
use Symfony\Component\VarDumper\Cloner\AbstractCloner;

class VarDumperManager
{
    public function initialize(): void
    {
        AbstractCloner::$defaultCasters[BaseData::class] = [DataVarDumperCaster::class, 'castDataObject'];
        AbstractCloner::$defaultCasters[BaseDataCollectable::class] = [DataVarDumperCaster::class, 'castDataCollectable'];
    }
}
