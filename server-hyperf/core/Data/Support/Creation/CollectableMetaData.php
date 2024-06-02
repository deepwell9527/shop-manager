<?php

namespace Deepwell\Data\Support\Creation;

use Hyperf\Paginator\AbstractPaginator;
use Hyperf\Paginator\LengthAwarePaginator;

class CollectableMetaData
{
    public function __construct(
        public ?int $paginator_total = null,
        public ?int $paginator_page = null,
        public ?int $paginator_per_page = null,
    ) {
    }

    public static function fromOther(
        mixed $items,
    ): self {
        if ($items instanceof LengthAwarePaginator) {
            return new self(
                paginator_total: $items->total(),
                paginator_page: $items->currentPage(),
                paginator_per_page: $items->perPage(),
            );
        }

        if ($items instanceof AbstractPaginator) {
            return new self(
                paginator_page: $items->currentPage(),
                paginator_per_page: $items->perPage()
            );
        }

        return new self();
    }
}
