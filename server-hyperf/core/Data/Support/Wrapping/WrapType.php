<?php

namespace Deepwell\Data\Support\Wrapping;

enum WrapType: string
{
    case UseGlobal = 'use_global';
    case Disabled = 'disabled';
    case Defined = 'defined';
}
