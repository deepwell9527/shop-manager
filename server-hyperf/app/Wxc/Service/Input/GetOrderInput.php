<?php

declare(strict_types=1);

namespace App\Wxc\Service\Input;

use Deepwell\Contract\AbstractQueryInput;
use Deepwell\Data\Optional;

class GetOrderInput extends AbstractQueryInput
{
    public int|Optional $order_id;
}