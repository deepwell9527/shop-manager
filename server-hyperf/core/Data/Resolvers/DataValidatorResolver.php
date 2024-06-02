<?php

namespace Deepwell\Data\Resolvers;

use Hyperf\Contract\Arrayable;
use Deepwell\Data\Contracts\BaseData;
use Deepwell\Data\Contracts\ValidateableData;
use Deepwell\Data\Support\Validation\DataRules;
use Deepwell\Data\Support\Validation\ValidationPath;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;
use Hyperf\Validation\Validator;
use function Hyperf\Support\call;

class DataValidatorResolver
{
    #[Inject]
    protected ValidatorFactoryInterface $validationFactory;

    public function __construct(
        protected DataValidationRulesResolver $dataValidationRulesResolver,
        protected DataValidationMessagesAndAttributesResolver $dataValidationMessagesAndAttributesResolver
    ) {
    }

    /** @param class-string<ValidateableData&BaseData> $dataClass */
    public function execute(
        string $dataClass,
        Arrayable|array $payload,
    ): Validator {
        $payload = $payload instanceof Arrayable ? $payload->toArray() : $payload;

        $rules = $this->dataValidationRulesResolver->execute(
            $dataClass,
            $payload,
            ValidationPath::create(),
            DataRules::create()
        );

        ['messages' => $messages, 'attributes' => $attributes] = $this->dataValidationMessagesAndAttributesResolver->execute(
            $dataClass,
            $payload,
            ValidationPath::create()
        );

        $validator = $this->validationFactory->make(
            $payload,
            $rules,
            $messages,
            $attributes
        );

        if (method_exists($dataClass, 'stopOnFirstFailure')) {
            $validator->stopOnFirstFailure(call([$dataClass, 'stopOnFirstFailure']));
        }

        $dataClass::withValidator($validator);

        return $validator;
    }
}
