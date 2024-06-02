<?php

namespace Deepwell\Data\Support\Partials\Segments;

class AllPartialSegment extends PartialSegment
{
    public function __toString(): string
    {
        return '*';
    }
}
