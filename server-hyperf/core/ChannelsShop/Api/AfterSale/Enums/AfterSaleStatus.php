<?php

namespace Deepwell\ChannelsShop\Api\AfterSale\Enums;

/**
 * 售后单当前状态枚举
 */
enum  AfterSaleStatus: string
{
    /**
     * 用户取消申请
     */
    case UserCanceled = 'USER_CANCELD';

    /**
     * 商家受理中
     */
    case MerchantProcessing = 'MERCHANT_PROCESSING';

    /**
     * 商家拒绝退款
     */
    case MerchantRejectRefund = 'MERCHANT_REJECT_REFUND';

    /**
     * 商家拒绝退货退款
     */
    case MerchantRejectReturn = 'MERCHANT_REJECT_RETURN';

    /**
     * 待买家退货
     */
    case UserWaitReturn = 'USER_WAIT_RETURN';

    /**
     * 退货退款关闭
     */
    case ReturnClosed = 'RETURN_CLOSED';

    /**
     * 待商家收货
     */
    case MerchantWaitReceipt = 'MERCHANT_WAIT_RECEIPT';

    /**
     * 商家逾期未退款
     */
    case MerchantOverdueRefund = 'MERCHANT_OVERDUE_REFUND';

    /**
     * 退款完成
     */
    case MerchantRefundSuccess = 'MERCHANT_REFUND_SUCCESS';

    /**
     * 退货退款完成
     */
    case MerchantReturnSuccess = 'MERCHANT_RETURN_SUCCESS';

    /**
     * 平台退款中
     */
    case PlatformRefunding = 'PLATFORM_REFUNDING';

    /**
     * 平台退款失败
     */
    case PlatformRefundFail = 'PLATFORM_REFUND_FAIL';

    /**
     * 待用户确认
     */
    case UserWaitConfirm = 'USER_WAIT_CONFIRM';

    /**
     * 商家打款失败，客服关闭售后
     */
    case MerchantRefundRetryFail = 'MERCHANT_REFUND_RETRY_FAIL';

    /**
     * 售后关闭
     */
    case MerchantFail = 'MERCHANT_FAIL';

    /**
     * 待用户处理商家协商
     */
    case UserWaitConfirmUpdate = 'USER_WAIT_CONFIRM_UPDATE';

    /**
     * 待用户处理商家代发起的售后申请
     */
    case UserWaitHandleMerchantAfterSale = 'USER_WAIT_HANDLE_MERCHANT_AFTER_SALE';
}

