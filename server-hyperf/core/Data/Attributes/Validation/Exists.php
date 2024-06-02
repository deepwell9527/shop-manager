<?php

namespace Deepwell\Data\Attributes\Validation;

use Attribute;
use Closure;
use Deepwell\Data\Support\Validation\References\RouteParameterReference;
use Deepwell\Data\Support\Validation\ValidationPath;
use Exception;
use Hyperf\Validation\Rules\Exists as BaseExists;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
class Exists extends ObjectValidationAttribute
{
    public function __construct(
        protected null|string|RouteParameterReference $table = null,
        protected null|string|RouteParameterReference $column = 'NULL',
        protected ?Closure                            $where = null,
        protected ?BaseExists                         $rule = null,
    )
    {
        if ($rule === null && $table === null) {
            throw new Exception('Could not make exists rule since a table or rule is required');
        }
    }

    public static function keyword(): string
    {
        return 'exists';
    }

    public static function create(string ...$parameters): static
    {
        return new static(rule: new BaseExists($parameters[0], $parameters[1] ?? 'NULL'));
    }

    public function getRule(ValidationPath $path): object|string
    {
        if ($this->rule) {
            return $this->rule;
        }

        $table = $this->normalizePossibleRouteReferenceParameter($this->table);
        $column = $this->normalizePossibleRouteReferenceParameter($this->column);

        $rule = new BaseExists(
            $table,
            $column
        );

        if ($this->where) {
            $rule->where($this->where);
        }

        return $this->rule = $rule;
    }
}
