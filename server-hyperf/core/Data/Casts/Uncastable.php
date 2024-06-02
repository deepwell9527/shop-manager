<?php

namespace Deepwell\Data\Casts;

class Uncastable
{
    public static Uncastable $instance;

    private function __construct()
    {

    }

    public static function create(): self
    {
        return container()->get(Uncastable::class);
    }
}
