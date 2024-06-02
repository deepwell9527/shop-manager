<?php

namespace Deepwell\ChannelsShop\Api\AfterSale\Dto;

use Deepwell\Data\Data;
use Deepwell\Data\Optional;

class AfterSaleDetails extends Data
{
    /**
     * 售后描述
     * @var string
     */
    public string $desc;

    /**
     * 发起售后的时候用户是否已经收到货
     * @var bool
     */
    public bool $receive_product;

    /**
     * 取消售后时间
     */
    public int|Optional $cancel_time;

    /**
     * 举证图片media_id列表, 根据mediaid获取文件内容接口
     * @var array<string>|Optional
     */
    public array|Optional $media_id_list;

    /**
     * 联系电话
     */
    public string|Optional $tel_number;
}