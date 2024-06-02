<?php

namespace Deepwell\Data\RuleInferrers;

use Deepwell\Data\Attributes\Validation\Sometimes;
use Deepwell\Data\Support\DataProperty;
use Deepwell\Data\Support\Validation\PropertyRules;
use Deepwell\Data\Support\Validation\ValidationContext;

class SometimesRuleInferrer implements RuleInferrer
{
    public function handle(
        DataProperty $property,
        PropertyRules $rules,
        ValidationContext $context,
    ): PropertyRules {
        if ($property->type->isOptional && ! $rules->hasType(Sometimes::class)) {
            $rules->prepend(new Sometimes());
        }

        return $rules;
    }
}
