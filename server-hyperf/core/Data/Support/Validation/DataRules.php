<?php

namespace Deepwell\Data\Support\Validation;


class DataRules
{
    /**
     * @param array<array|\Deepwell\Data\Support\Validation\PropertyRules> $rules
     */
    public function __construct(
        public array $rules = [],
    ) {
    }

    public static function create(): self
    {
        return new self();
    }

    public function add(
        ValidationPath $path,
        array $rules
    ): self {
        $this->rules[$path->get()] = $rules;

        return $this;
    }

    public function addCollection(
        ValidationPath $path,
        $rules
    ): self {
        $this->rules["{$path->get()}.*"] = $rules;

        return $this;
    }
}
