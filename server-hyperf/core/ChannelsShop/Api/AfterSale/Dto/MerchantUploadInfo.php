<?php

namespace Deepwell\ChannelsShop\Api\AfterSale\Dto;

use Deepwell\Data\Data;

class MerchantUploadInfo extends Data
{
    /**
     * 拒绝原因
     */
    public string $reject_reason = '';

    /**
     * 退款凭证，数组类型，包含字符串元素
     * @var array<string>
     */
    public array $refund_certificates = [];
}