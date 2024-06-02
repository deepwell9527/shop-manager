<?php

namespace Deepwell\ChannelsShop\Api\Product\Enums;

/**
 * 枚举类，表示商品草稿状态
 */
enum SkuEditStatus: int
{
    /**
     * 初始值
     */
    case Initial = 0;

    /**
     * 编辑中
     */
    case Editing = 1;

    /**
     * 审核中
     */
    case Reviewing = 2;

    /**
     * 审核失败
     */
    case ReviewFailed = 3;

    /**
     * 审核成功
     */
    case ReviewPassed = 4;

    /**
     * 商品异步提交，上传中
     * 处于该状态的商品调用上架商品接口会返回10020067
     */
    case AsyncSubmitting = 7;

    /**
     * 商品异步提交，上传失败
     * 请重新提交
     */
    case AsyncSubmissionFailed = 8;
}
