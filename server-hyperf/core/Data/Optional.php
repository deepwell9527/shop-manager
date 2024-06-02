<?php

namespace Deepwell\Data;

class Optional
{
    public static function create(): Optional
    {
        return new self();
    }
}
