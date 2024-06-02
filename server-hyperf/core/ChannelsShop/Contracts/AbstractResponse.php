<?php

namespace Deepwell\ChannelsShop\Contracts;

use Deepwell\Data\Data;

abstract class AbstractResponse extends Data
{
    public int $errcode;

    public string $errmsg;
}