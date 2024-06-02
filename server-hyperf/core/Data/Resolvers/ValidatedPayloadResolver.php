<?php

namespace Deepwell\Data\Resolvers;

use Deepwell\Data\Contracts\BaseData;
use Deepwell\Data\Contracts\ValidateableData;
use Hyperf\Contract\ValidatorInterface;
use Hyperf\Validation\ValidationException;
use function Hyperf\Support\call;

class ValidatedPayloadResolver
{
    /** @param class-string<ValidateableData&BaseData> $dataClass */
    public function execute(
        string $dataClass,
        ValidatorInterface $validator
    ): array {
        try {
            $validator->validate();
        } catch (ValidationException $exception) {
            if (method_exists($dataClass, 'redirect')) {
                $exception->redirectTo(call([$dataClass, 'redirect']));
            }

            if (method_exists($dataClass, 'redirectRoute')) {
                $exception->redirectTo(route(call([$dataClass, 'redirectRoute'])));
            }

            if (method_exists($dataClass, 'errorBag')) {
                $exception->errorBag(call([$dataClass, 'errorBag']));
            }

            throw $exception;
        }

        return $validator->validated();
    }
}
