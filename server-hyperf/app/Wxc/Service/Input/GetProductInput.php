<?php

declare(strict_types=1);

namespace App\Wxc\Service\Input;

use Deepwell\Contract\AbstractQueryInput;
use Deepwell\Data\Optional;

class GetProductInput extends AbstractQueryInput
{
    public int|Optional $product_id;

    public int|Optional $sku_id;

}