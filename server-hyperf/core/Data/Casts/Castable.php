<?php

namespace Deepwell\Data\Casts;

interface Castable
{
    public static function castUsing(array $arguments);
}
