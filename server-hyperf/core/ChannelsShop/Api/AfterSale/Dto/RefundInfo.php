<?php

namespace Deepwell\ChannelsShop\Api\AfterSale\Dto;

use Deepwell\ChannelsShop\Api\AfterSale\Enums\RefundReason;
use Deepwell\Data\Data;
use Deepwell\Data\Optional;

class RefundInfo extends Data
{
    /**
     * 退款金额（分）
     * @var int
     */
    public int $amount;

    /**
     * 标明售后单退款直接原因
     */
    public RefundReason|Optional $refund_reason;
}