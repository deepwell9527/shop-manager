<?php

namespace Deepwell\ChannelsShop\Api\AfterSale\Dto;

use Deepwell\Data\Data;

class ApplyRefundResp extends Data
{
    /**
     * 错误码
     */
    public string $code;

    /**
     * 状态码
     */
    public int $ret;

    /**
     * 描述
     */
    public string $message;
}