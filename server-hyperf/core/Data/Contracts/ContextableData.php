<?php

namespace Deepwell\Data\Contracts;

use Deepwell\Data\Support\Transformation\DataContext;

interface ContextableData
{
    public function getDataContext(): DataContext;
}
