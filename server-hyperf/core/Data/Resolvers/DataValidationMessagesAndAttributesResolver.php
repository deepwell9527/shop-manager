<?php

namespace Deepwell\Data\Resolvers;

use Deepwell\Data\Support\DataConfig;
use Deepwell\Data\Support\Validation\ValidationPath;
use Hyperf\Collection\Arr;
use function Hyperf\Collection\collect;
use function Hyperf\Support\call;

class DataValidationMessagesAndAttributesResolver
{
    public function __construct(
        protected DataConfig $dataConfig,
    )
    {
    }

    public function execute(
        string         $class,
        array          $fullPayload,
        ValidationPath $path,
    ): array
    {
        $dataClass = $this->dataConfig->getDataClass($class);

        $messages = [];
        $attributes = [];

        foreach ($dataClass->properties as $dataProperty) {
            $propertyPath = $path->property($dataProperty->inputMappedName ?? $dataProperty->name);

            if (
                $dataProperty->type->kind->isNonDataRelated()
                && $dataProperty->validate === false
            ) {
                continue;
            }

            if (Arr::has($fullPayload, $propertyPath->get()) === false) {
                continue;
            }

            if ($dataProperty->type->kind->isDataObject()) {
                $nested = $this->execute(
                    $dataProperty->type->dataClass,
                    $fullPayload,
                    $propertyPath,
                );

                $messages = array_merge($messages, $nested['messages']);
                $attributes = array_merge($attributes, $nested['attributes']);

                continue;
            }

            if ($dataProperty->type->kind->isDataCollectable()) {
                $collected = $this->execute(
                    $dataProperty->type->dataClass,
                    $fullPayload,
                    $propertyPath->property('*'),
                );

                $messages = array_merge($messages, $collected['messages']);
                $attributes = array_merge($attributes, $collected['attributes']);

                continue;
            }
        }

        if (method_exists($class, 'messages')) {
            $messages = collect(call([$class, 'messages']))
                ->keyBy(
                    fn(mixed $messages, string $key) => !str_contains($key, '.') && is_string($messages)
                        ? $path->property("*.{$key}")->get()
                        : $path->property($key)->get()
                )
                ->merge($messages)
                ->all();
        }

        if (method_exists($class, 'attributes')) {
            $attributes = collect(call([$class, 'attributes']))
                ->keyBy(fn(mixed $messages, string $key) => $path->property($key)->get())
                ->merge($attributes)
                ->all();
        }

        return ['messages' => $messages, 'attributes' => $attributes];
    }
}
