<?php

namespace Deepwell\Data\RuleInferrers;

use Deepwell\Data\Attributes\Validation\Nullable;
use Deepwell\Data\Support\DataProperty;
use Deepwell\Data\Support\Validation\PropertyRules;
use Deepwell\Data\Support\Validation\ValidationContext;

class NullableRuleInferrer implements RuleInferrer
{
    public function handle(
        DataProperty $property,
        PropertyRules $rules,
        ValidationContext $context,
    ): PropertyRules {
        if ($property->type->isNullable && ! $rules->hasType(Nullable::class)) {
            $rules->prepend(new Nullable());
        }

        return $rules;
    }
}
