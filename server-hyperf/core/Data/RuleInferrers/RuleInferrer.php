<?php

namespace Deepwell\Data\RuleInferrers;

use Deepwell\Data\Support\DataProperty;
use Deepwell\Data\Support\Validation\PropertyRules;
use Deepwell\Data\Support\Validation\ValidationContext;

interface RuleInferrer
{
    public function handle(DataProperty $property, PropertyRules $rules, ValidationContext $context): PropertyRules;
}
