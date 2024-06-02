<?php

namespace Deepwell\ChannelsShop\Api\AfterSale\Enums;

/**
 * 枚举类，表示售后单退款的直接原因
 */
enum RefundReason: int
{
    /**
     * 商家通过店铺管理页或者小助手发起退款
     */
    case InitiatedBySeller = 1;

    /**
     * 商家同意买家未上传物流单号情况下确认收货并退款，该场景限于订单无运费险
     */
    case AgreedWithoutLogisticsBySeller = 2;

    /**
     * 商家通过后台API发起退款
     */
    case InitiatedViaBackendApi = 3;

    /**
     * 未发货售后平台自动同意退款
     */
    case AutoApprovedUnshipped = 4;

    /**
     * 平台介入纠纷退款
     */
    case PlatformInterventionDispute = 5;

    /**
     * 特殊场景下平台强制退款
     */
    case PlatformForcedRefund = 6;

    /**
     * 买家同意没有上传物流单号情况下，商家确认收货并退款，该场景限于订单包含运费险，并无法理赔
     */
    case AgreedWithoutLogisticsByBuyerWithInsurance = 7;

    /**
     * 商家发货超时，平台退款
     */
    case RefundedDueToSellerShipmentDelay = 8;

    /**
     * 商家处理买家售后申请超时，平台自动同意退款
     */
    case AutoApprovedDueToSellerResponseDelay = 9;

    /**
     * 用户确认收货超时，平台退款
     */
    case RefundedDueToCustomerReceiptDelay = 10;

    /**
     * 商家确认收货超时，平台退款
     */
    case RefundedDueToSellerReceiptDelay = 11;
}