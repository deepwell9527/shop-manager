<?php

namespace Deepwell\Data\Attributes;

use Deepwell\Data\Casts\Cast;

interface GetsCast
{
    public function get(): Cast;
}
