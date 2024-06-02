<?php
declare(strict_types=1);

namespace App\Wxc\Service;

use App\Wxc\Mapper\WxcOrderMapper;
use App\Wxc\Model\WxcOrder;
use App\Wxc\Model\WxcOrderDeliveryInfo;
use App\Wxc\Model\WxcOrderExtInfo;
use App\Wxc\Model\WxcOrderPayInfo;
use App\Wxc\Model\WxcOrderPriceInfo;
use App\Wxc\Model\WxcOrderProductInfo;
use App\Wxc\Model\WxcOrderSharerInfo;
use App\Wxc\Service\Input\SaveOrderDetailInput;
use Mine\Abstracts\AbstractService;
use Mine\Annotation\Transaction;

/**
 * 订单服务类
 */
class WxcOrderService extends AbstractService
{
    /**
     * @var WxcOrderMapper
     */
    public $mapper;

    public function __construct(WxcOrderMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    public function details(mixed $id)
    {
        $order = WxcOrder::with([
            'productInfos',
            'priceInfo',
            'deliveryInfo'
        ])->find($id);

        return $order;
    }

    #[Transaction]
    public function saveOrderDetail(SaveOrderDetailInput $input): void
    {
        $order = $input->order;
        // 保存订单主要信息
        $item = WxcOrder::find($order->order_id);
        $mainInfo = $order->exclude('order_detail', 'aftersale_detail')->toArray();
        $mainInfo['created_at'] = $mainInfo['create_time'];
        $mainInfo['updated_at'] = $mainInfo['update_time'];
        if (!$item) {
            $item = new WxcOrder();
            $item->app_id = $input->app_id;
            $item->order_id = $order->order_id;
        }
        $item->fill($mainInfo)->save();

        $detail = $order->order_detail;

        // 保存订单配送信息
        $deliveryInfo = WxcOrderDeliveryInfo::find($order->order_id);
        if (!$deliveryInfo) {
            $deliveryInfo = new WxcOrderDeliveryInfo();
            $deliveryInfo->app_id = $input->app_id;
            $deliveryInfo->order_id = $order->order_id;
        }
        $deliveryInfo->fill($detail->delivery_info->toArray())->save();

        // 保存订单额外信息
        $extInfo = WxcOrderExtInfo::find($order->order_id);
        if (!$extInfo) {
            $extInfo = new WxcOrderExtInfo();
            $extInfo->app_id = $input->app_id;
            $extInfo->order_id = $order->order_id;
        }
        $extInfo->fill($detail->ext_info->toArray())->save();

        // 保存订单支付信息
        $payInfo = WxcOrderPayInfo::find($order->order_id);
        if (!$payInfo) {
            $payInfo = new WxcOrderPayInfo();
            $payInfo->app_id = $input->app_id;
            $payInfo->order_id = $order->order_id;
        }
        $payInfo->fill($detail->pay_info->toArray())->save();

        // 保存订单价格信息
        $priceInfo = WxcOrderPriceInfo::find($order->order_id);
        if (!$priceInfo) {
            $priceInfo = new WxcOrderPriceInfo();
            $priceInfo->app_id = $input->app_id;
            $priceInfo->order_id = $order->order_id;
        }
        $priceInfo->fill($detail->price_info->toArray())->save();

        // 保存订单商品信息
        foreach ($detail->product_infos as $pItem) {
            $productInfo = WxcOrderProductInfo::where('order_id', $order->order_id)->where('product_id', $pItem->product_id)->where('sku_id', $pItem->sku_id)->first();
            if (!$productInfo) {
                $productInfo = new WxcOrderProductInfo();
                $productInfo->app_id = $input->app_id;
                $productInfo->order_id = $order->order_id;
            }
            $productInfo->fill($pItem->toArray())->save();
        }

        // 保存订单分享员信息
        if (isset($detail->sharer_info)) {
            $sharerInfo = WxcOrderSharerInfo::where('order_id', $order->order_id)->where('sharer_openid', $detail->sharer_info->sharer_openid)->first();
            if (!$sharerInfo) {
                $sharerInfo = new WxcOrderSharerInfo();
                $sharerInfo->app_id = $input->app_id;
                $sharerInfo->order_id = $order->order_id;
            }
            $sharerInfo->fill($detail->sharer_info->toArray())->save();
        }
        if (!empty($detail->sku_sharer_infos)) {
            foreach ($detail->sku_sharer_infos as $sItem) {
                $sharerInfo = WxcOrderSharerInfo::where('order_id', $order->order_id)->where('sharer_openid', $sItem->sharer_openid)->where('sku_id', $sItem->sku_id)->first();
                if (!$sharerInfo) {
                    $sharerInfo = new WxcOrderSharerInfo();
                    $sharerInfo->app_id = $input->app_id;
                    $sharerInfo->order_id = $order->order_id;
                }
                $sharerInfo->fill($sItem->toArray())->save();
            }
        }
    }

    public function sync()
    {
        $shopServ = container()->get(WxcShopService::class);
        $shopConfList = $shopServ->getList([
            'select' => 'app_id',
        ]);

        $queueServ = container()->get(WxcQueueService::class);
        $queueServ->setSite(get_current_site());
        foreach ($shopConfList as $conf) {
            $queueServ->syncOrder($conf['app_id']);
        }

        return ['status' => 'promise', 'message' => '同步中'];
    }
}