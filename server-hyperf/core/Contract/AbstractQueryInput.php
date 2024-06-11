<?php
declare(strict_types=1);

namespace Deepwell\Contract;

use Deepwell\Data\Data;
use Deepwell\Data\Optional;
use Hyperf\Database\Model\Builder;

abstract class AbstractQueryInput extends Data implements QueryInputInterface
{
    public array $select = ['*'];

    public array|Optional $with = [];

    public function toQuery(Builder $query): Builder
    {
        foreach ($this->toArray() as $key => $value) {
            if ($key === 'select') {
                $query->select(implode(',', $value));
            } elseif ($key === 'with') {
                $query->with($value);
            } else {
                if (is_array($value)) {
                    $query->whereIn($key, $value);
                } else {
                    $query->where($key, $value);
                }
            }
        }
        return $query;
    }
}