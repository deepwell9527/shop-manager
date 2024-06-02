<?php

namespace Deepwell\ChannelsShop\Api\Order\Dto;

use Deepwell\ChannelsShop\Api\Order\Enums\CommissionStatus;
use Deepwell\ChannelsShop\Api\Order\Enums\ProfitRoleType;
use Deepwell\Data\Data;

class CommissionInfo extends Data
{
    /**
     * 商品skuid
     * @var int
     */
    public int $sku_id;

    /**
     * 分账方昵称
     * @var string
     */
    public string $nickname;

    /**
     * 分账方类型，0：达人，1：团长
     */
    public ProfitRoleType $type;

    /**
     * 分账状态，1：未结算，2：已结算
     */
    public CommissionStatus $status;

    /**
     * 分账金额
     * @var float
     */
    public float $amount;

    /**
     * 达人视频号id
     * @var string
     */
    public string $finder_id;

    /**
     * 达人openfinderid
     * @var string
     */
    public string $openfinderid;
}