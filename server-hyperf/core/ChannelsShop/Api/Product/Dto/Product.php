<?php

namespace Deepwell\ChannelsShop\Api\Product\Dto;

use Deepwell\ChannelsShop\Api\Product\Enums\DeliverMethod;
use Deepwell\ChannelsShop\Api\Product\Enums\ProductType;
use Deepwell\ChannelsShop\Api\Product\Enums\SkuEditStatus;
use Deepwell\ChannelsShop\Api\Product\Enums\SkuStatus;
use Deepwell\Data\Data;
use Deepwell\Data\Optional;
use Hyperf\Collection\Collection;

class Product extends Data
{
    /**
     * 小店内部商品ID
     * @var string
     */
    public string $product_id;

    /**
     * 商家自定义商品ID
     */
    public string|Optional $out_product_id;

    /**
     * 标题
     * @var string
     */
    public string $title;

    /**
     * 副标题
     */
    public string|Optional $sub_title;

    /**
     * 主图，多张，列表，最多9张，每张不超过2MB
     * @var string[] 数组
     */
    public array $head_imgs;

    /**
     * 商品详情
     */
    public Desc|Optional $desc_info;

    /**
     * 发货方式，0-快递发货；1-无需快递，默认为0，若为无需快递，则无需填写运费模版id
     */
    public DeliverMethod $deliver_method;

    /**
     * 运费模板ID
     */
    public ExpressInfo|Optional $expressInfo;

    /**
     * 售后说明
     * @var string
     */
    public string $aftersale_desc;

    /**
     * 限购信息
     * @var LimitedInfo
     */
    public LimitedInfo $limited_info;

    /**
     * 其他服务，如运费险、先付后发、七天无理由
     * @var ExtraService
     */
    public ExtraService $extra_service;

    /**
     * 商品线上状态
     */
    public SkuStatus $status;

    /**
     * 商品草稿状态
     */
    public SkuEditStatus|Optional $edit_status;

    /**
     * 商品 SKU 最小价格（单位：分）
     * @var int
     */
    public int $min_price;

    /**
     * 商家需要先申请可使用类目
     * @var Collection<int,Category>
     */
    public Collection $cats;

    /**
     * 商品属性数组
     * @var Collection<int,SkuAttr>
     */
    public Collection $attrs;

    /**
     * 商品编码
     * @var string
     */
    public string $spu_code;

    /**
     * 品牌id，无品牌为“2100000000”
     * @var string
     */
    public string $brand_id;

    /**
     * SKU数组
     * @var Collection<int,Sku>
     */
    public Collection $skus;

    /**
     * 商品类型
     */
    public ProductType $product_type;

    /**
     * 商品草稿最近一次修改时
     */
    public int $edit_time;

    /**
     * 商品的售后地址id
     */
    public int|Optional $after_sale_info_after_sale_address_id;

    /**
     * 当商品类型位福袋抽奖商品（即product_type==2）且该抽奖商品由橱窗的自营商品导入生成时有值
     */
    public int|Optional $src_product_id;

    /**
     * 商品资质列表
     * @var ProductQualityInfo[]
     */
    public array $product_qua_infos;
}