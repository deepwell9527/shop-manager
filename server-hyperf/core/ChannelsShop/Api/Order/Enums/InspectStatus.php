<?php

namespace Deepwell\ChannelsShop\Api\Order\Enums;

/**
 * 质检状态枚举
 */
enum InspectStatus: int
{
    /**
     * 待录入送检信息
     */
    case AwaitingEntryForInspection = 0;

    /**
     * 待送检
     */
    case AwaitingInspection = 1;

    /**
     * 未入库已取消
     */
    case CancelledWithoutStorage = 2;

    /**
     * 入库异常
     */
    case StorageException = 3;

    /**
     * 已入库
     */
    case Stored = 4;

    /**
     * 质检中
     */
    case Inspecting = 5;

    /**
     * 待出库
     */
    case AwaitingOutbound = 6;

    /**
     * 出库异常
     */
    case OutboundException = 7;

    /**
     * 待自提
     */
    case AwaitingSelfPickup = 8;

    /**
     * 已取消已自提
     */
    case CancelledAndSelfPickedUp = 10;

    /**
     * 已发货
     */
    case Shipped = 11;

    /**
     * 待重新送检
     */
    case AwaitingReinspection = 12;

    /**
     * 已达送检上限
     */
    case InspectionLimitReached = 13;

    /**
     * 待驿站入库
     */
    case AwaitingCourierStorage = 14;
}
