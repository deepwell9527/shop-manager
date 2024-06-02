<?php

namespace Deepwell\Data\Attributes;

use Attribute;
use Deepwell\Data\Mappers\NameMapper;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_PROPERTY)]
class MapName
{
    public function __construct(public string|int|NameMapper $input, public string|int|NameMapper|null $output = null)
    {
        $this->output ??= $this->input;
    }
}
