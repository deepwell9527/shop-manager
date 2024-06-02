<?php

namespace Deepwell\Data\RuleInferrers;

use Deepwell\Data\Attributes\Validation\BooleanType;
use Deepwell\Data\Attributes\Validation\Nullable;
use Deepwell\Data\Attributes\Validation\Present;
use Deepwell\Data\Attributes\Validation\Required;
use Deepwell\Data\Support\DataProperty;
use Deepwell\Data\Support\Validation\PropertyRules;
use Deepwell\Data\Support\Validation\RequiringRule;
use Deepwell\Data\Support\Validation\ValidationContext;

class RequiredRuleInferrer implements RuleInferrer
{
    public function handle(
        DataProperty $property,
        PropertyRules $rules,
        ValidationContext $context,
    ): PropertyRules {
        if ($this->shouldAddRule($property, $rules)) {
            $rules->prepend(new Required());
        }

        return $rules;
    }

    protected function shouldAddRule(DataProperty $property, PropertyRules $rules): bool
    {
        if ($property->type->isNullable || $property->type->isOptional) {
            return false;
        }

        if ($property->type->kind->isDataCollectable() && $rules->hasType(Present::class)) {
            return false;
        }

        if ($rules->hasType(BooleanType::class)) {
            return false;
        }

        if ($rules->hasType(Nullable::class)) {
            return false;
        }

        if ($rules->hasType(RequiringRule::class)) {
            return false;
        }

        return true;
    }
}
