<?php

namespace Deepwell\Data\Support\EloquentCasts;

use Deepwell\Data\Contracts\BaseData;
use Deepwell\Data\Contracts\TransformableData;
use Deepwell\Data\Exceptions\CannotCastData;
use Deepwell\Data\Support\DataConfig;
use Hyperf\Contract\CastsAttributes;

class DataEloquentCast implements CastsAttributes
{
    protected DataConfig $dataConfig;

    public function __construct(
        /** @var class-string<BaseData> $dataClass */
        protected string $dataClass,
        /** @var string[] $arguments */
        protected array  $arguments = []
    )
    {
        $this->dataConfig = container()->get(DataConfig::class);
    }

    public function get($model, string $key, $value, array $attributes): ?BaseData
    {
        if (is_null($value) && in_array('default', $this->arguments)) {
            $value = '{}';
        }

        if ($value === null) {
            return null;
        }

        $payload = json_decode($value, true, flags: JSON_THROW_ON_ERROR);

        if ($this->isAbstractClassCast()) {
            /** @var class-string<BaseData> $dataClass */
            $dataClass = $this->dataConfig->morphMap->getMorphedDataClass($payload['type']) ?? $payload['type'];

            return $dataClass::from($payload['data']);
        }

        return ($this->dataClass)::from($payload);
    }

    protected function isAbstractClassCast(): bool
    {
        return $this->dataConfig->getDataClass($this->dataClass)->isAbstract;
    }

    public function set($model, string $key, $value, array $attributes): ?string
    {
        if ($value === null) {
            return null;
        }

        $isAbstractClassCast = $this->isAbstractClassCast();

        if (is_array($value) && !$isAbstractClassCast) {
            $value = ($this->dataClass)::from($value);
        }

        if (!$value instanceof BaseData) {
            throw CannotCastData::shouldBeData($model::class, $key);
        }

        if (!$value instanceof TransformableData) {
            throw CannotCastData::shouldBeTransformableData($model::class, $key);
        }

        if ($isAbstractClassCast) {
            return json_encode([
                'type' => $this->dataConfig->morphMap->getDataClassAlias($value::class) ?? $value::class,
                'data' => json_decode($value->toJson(), associative: true, flags: JSON_THROW_ON_ERROR),
            ]);
        }

        return $value->toJson();
    }
}
