<?php

namespace Deepwell\ChannelsShop\Api\Order\Dto;

use Deepwell\Data\Data;

class AddressInfo extends Data
{
    /**
     * 收货人姓名
     * @var string
     */
    public string $user_name;

    /**
     * 邮编
     * @var string
     */
    public string $postal_code;

    /**
     * 省份
     * @var string
     */
    public string $province_name;

    /**
     * 城市
     * @var string
     */
    public string $city_name;

    /**
     * 区
     * @var string
     */
    public string $county_name;

    /**
     * 详细地址
     * @var string
     */
    public string $detail_info;

    /**
     * 国家码，已废弃，请勿使用
     * @var string
     */
    public string $national_code;

    /**
     * 联系方式
     * @var string
     */
    public string $tel_number;

    /**
     * 门牌号码
     * @var string
     */
    public string $house_number;

    /**
     * 虚拟发货订单联系方式(deliver_method=1时返回)
     * @var string
     */
    public string $virtual_order_tel_number;

    /**
     * 额外的联系方式信息（虚拟号码相关）
     */
    public TelNumberExtInfo $tel_number_ext_info;

    /**
     * 0：不使用虚拟号码，1：使用虚拟号码
     * @var int
     */
    public int $use_tel_number;

    /**
     * 标识当前店铺下一个唯一的用户收货地址
     * @var string
     */
    public string $hash_code;
}