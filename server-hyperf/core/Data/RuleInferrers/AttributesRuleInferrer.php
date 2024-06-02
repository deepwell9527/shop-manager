<?php

namespace Deepwell\Data\RuleInferrers;

use Deepwell\Data\Attributes\Validation\Present;
use Deepwell\Data\Support\DataProperty;
use Deepwell\Data\Support\Validation\PropertyRules;
use Deepwell\Data\Support\Validation\RequiringRule;
use Deepwell\Data\Support\Validation\RuleNormalizer;
use Deepwell\Data\Support\Validation\ValidationContext;
use Deepwell\Data\Support\Validation\ValidationRule;

class AttributesRuleInferrer implements RuleInferrer
{
    public function __construct(protected RuleNormalizer $rulesDenormalizer)
    {
    }

    public function handle(
        DataProperty $property,
        PropertyRules $rules,
        ValidationContext $context,
    ): PropertyRules {
        $property
            ->attributes
            ->filter(fn (object $attribute) => $attribute instanceof ValidationRule)
            ->each(function (ValidationRule $rule) use ($rules) {
                if($rule instanceof Present && $rules->hasType(RequiringRule::class)) {
                    $rules->removeType(RequiringRule::class);
                }

                $rules->add(
                    ...$this->rulesDenormalizer->execute($rule)
                );
            });

        return $rules;
    }
}
