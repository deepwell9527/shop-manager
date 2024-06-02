<?php

namespace Deepwell\Data\Contracts;

use Hyperf\Contract\Arrayable;
use Hyperf\Validation\Validator;

interface ValidateableData
{
    public static function validate(Arrayable|array $payload): Arrayable|array;

    /**
     * @return static
     */
    public static function validateAndCreate(Arrayable|array $payload): static;

    public static function withValidator(Validator $validator): void;
}
