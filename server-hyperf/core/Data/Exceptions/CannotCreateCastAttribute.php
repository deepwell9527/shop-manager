<?php

namespace Deepwell\Data\Exceptions;

use Exception;
use Deepwell\Data\Casts\Cast;
use Deepwell\Data\Casts\Castable;

class CannotCreateCastAttribute extends Exception
{
    public static function notACast(): self
    {
        $cast = Cast::class;

        return new self("WithCast attribute needs a cast that implements `{$cast}`");
    }

    public static function notACastable(): self
    {
        $cast = Castable::class;

        return new self("WithCastable attribute needs a class that implements `{$cast}`");
    }
}
