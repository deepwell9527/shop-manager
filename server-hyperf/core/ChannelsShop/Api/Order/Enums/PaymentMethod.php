<?php

namespace Deepwell\ChannelsShop\Api\Order\Enums;

enum PaymentMethod: int
{
    /**
     * 微信支付
     */
    case WeChatPay = 1;

    /**
     * 先用后付
     */
    case PayLater = 2;

    /**
     * 抽奖商品0元订单
     */
    case LuckyDrawZeroOrder = 3;

    /**
     * 会员积分兑换订单
     */
    case MembershipPointsExchange = 4;
}
