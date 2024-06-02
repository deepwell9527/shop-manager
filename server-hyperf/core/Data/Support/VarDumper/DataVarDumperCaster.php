<?php

namespace Deepwell\Data\Support\VarDumper;

use Deepwell\Data\Contracts\TransformableData;
use Symfony\Component\VarDumper\Cloner\Stub;

class DataVarDumperCaster
{
    public static function castDataObject(TransformableData $data, array $a, Stub $stub, bool $isNested)
    {
        return $data->all();
    }

    public static function castDataCollectable(TransformableData $data, array $a, Stub $stub, bool $isNested)
    {
        return [
            'items' => $data->all(),
        ];
    }
}
