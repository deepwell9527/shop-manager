<?php

namespace App\Wxc\Enums;

/**
 * 分佣比例模式
 */
enum RateMode: int
{
    /**
     *  默认，优先级：商品>等级身份
     */
    case Default = 1;

    /**
     *  自定义，优先级：商品>分享员
     */
    case Custom = 2;
}
