<?php
declare(strict_types=1);

namespace Deepwell\ChannelsShop\Api\Product\Dto;

use Deepwell\Data\Data;

class SkuAttr extends Data
{
    /**
     * 属性键（属性自定义用）
     */
    public string $attr_key;

    /**
     * 属性值value（属性自定义用），参数规则如下：<br>
     * 1.当获取类目信息接口中返回的type：为 select_many，
     * attr_value的格式：多个选项用分号;隔开<br>
     * 示例：某商品的适用人群属性，选择了：青年、中年，则 attr_value的值为：青年;中年
     * ------------------------------------------------------------------<br>
     * 2.当获取类目信息接口中返回的type：为 integer_unit/decimal4_unit
     * attr_value格式：数值 单位，用单个空格隔开<br>
     * 示例：某商品的重量属性，要求integer_unit属性类型，数值部分为 18，单位选择为kg，则 attr_value的值为：18 kg
     * ------------------------------------------------------------------<br>
     * 3.当获取类目信息接口中返回的type：为 integer/decimal4
     * attr_value 的格式：字符串形式的数字
     */
    public string $attr_value;
}