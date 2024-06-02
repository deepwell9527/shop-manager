<?php

namespace Deepwell\Data\RuleInferrers;

use BackedEnum;
use Deepwell\Data\Attributes\Validation\ArrayType;
use Deepwell\Data\Attributes\Validation\BooleanType;
use Deepwell\Data\Attributes\Validation\Enum;
use Deepwell\Data\Attributes\Validation\Numeric;
use Deepwell\Data\Attributes\Validation\StringType;
use Deepwell\Data\Support\DataProperty;
use Deepwell\Data\Support\Validation\PropertyRules;
use Deepwell\Data\Support\Validation\RequiringRule;
use Deepwell\Data\Support\Validation\ValidationContext;

class BuiltInTypesRuleInferrer implements RuleInferrer
{
    public function handle(
        DataProperty $property,
        PropertyRules $rules,
        ValidationContext $context,
    ): PropertyRules {
        if ($property->type->type->acceptsType('int')) {
            $rules->add(new Numeric());
        }

        if ($property->type->type->acceptsType('string')) {
            $rules->add(new StringType());
        }

        if ($property->type->type->acceptsType('bool')) {
            $rules->removeType(RequiringRule::class);

            $rules->add(new BooleanType());
        }

        if ($property->type->type->acceptsType('float')) {
            $rules->add(new Numeric());
        }

        if ($property->type->type->acceptsType('array')) {
            $rules->add(new ArrayType());
        }

        if ($enumClass = $property->type->type->findAcceptedTypeForBaseType(BackedEnum::class)) {
            $rules->add(new Enum($enumClass));
        }

        return $rules;
    }
}
