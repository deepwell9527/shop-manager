<?php

namespace Deepwell\Data\Support\Wrapping;

enum WrapExecutionType
{
    case Disabled;
    case Enabled;
    case TemporarilyDisabled; // Internal

    public function shouldExecute(): bool
    {
        return $this === WrapExecutionType::Enabled;
    }
}
