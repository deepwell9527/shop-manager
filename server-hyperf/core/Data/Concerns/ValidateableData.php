<?php

namespace Deepwell\Data\Concerns;

use Deepwell\Data\Resolvers\DataValidationRulesResolver;
use Deepwell\Data\Support\DataContainer;
use Deepwell\Data\Support\Validation\DataRules;
use Deepwell\Data\Support\Validation\ValidationContext;
use Deepwell\Data\Support\Validation\ValidationPath;
use Hyperf\Contract\Arrayable;
use Hyperf\Validation\Validator;

/**
 * @method static array rules(ValidationContext $context)
 * @method static array messages(...$args)
 * @method static array attributes(...$args)
 * @method static bool stopOnFirstFailure()
 * @method static string redirect()
 * @method static string redirectRoute()
 * @method static string errorBag()
 */
trait ValidateableData
{
    public static function validate(Arrayable|array $payload): Arrayable|array
    {
        $validator = DataContainer::get()->dataValidatorResolver()->execute(
            static::class,
            $payload,
        );

        //dump($validator->getRules());

        return DataContainer::get()->validatedPayloadResolver()->execute(
            static::class,
            $validator,
        );
    }

    public static function validateAndCreate(Arrayable|array $payload): static
    {
        return static::factory()->alwaysValidate()->from($payload);
    }

    public static function withValidator(Validator $validator): void
    {
        return;
    }

    public static function getValidationRules(array $payload): array
    {
        return container()->get(DataValidationRulesResolver::class)->execute(
            static::class,
            $payload,
            ValidationPath::create(),
            DataRules::create(),
        );
    }
}
