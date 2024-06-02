<?php
declare(strict_types=1);

namespace App\Wxc\Service\Input;

use Deepwell\ChannelsShop\Api\Order\Dto\Order;
use Deepwell\Data\Data;

class  SaveOrderDetailInput extends Data
{
    public string $app_id;

    public Order $order;
}