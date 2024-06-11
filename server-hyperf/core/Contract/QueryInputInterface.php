<?php

namespace Deepwell\Contract;

use Hyperf\Database\Model\Builder;

interface QueryInputInterface
{

    public function toQuery(Builder $query):Builder;
}